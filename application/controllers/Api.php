<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('m_api');
        date_default_timezone_set("asia/jakarta");
    }

	public function index()
	{
		$this->load->view('i_api');
	}
	public function manualabsensijson() {
		if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['id_siswa'])) {
			$key = $this->input->get('key');
			$cekkey = $this->m_api->getkey();
	
			if ($cekkey[0]->key == $key) {
				$iddev = $this->input->get('iddev');
				$id_siswa = $this->input->get('id_siswa');
	
				// Verify if student ID exists
				$ceksiswa = $this->m_api->get_siswa_by_id($id_siswa);
				if (!$ceksiswa) {
					$notif = array('status' => 'failed', 'ket' => 'ID SISWA TIDAK DITEMUKAN');
					echo json_encode($notif);
					return;
				}
	
				// Rest of the attendance logic
				$device = $this->m_api->getdevice($iddev);
				$count = count($device);
	
				if ($count > 0) {
					$hariIni = date('l');
	
					if ($hariIni == 'Sunday') {
						$notif = array('status' => 'failed', 'ket' => 'ABSENSI TIDAK TERSEDIA PADA HARI MINGGU');
						echo json_encode($notif);
						return;
					}
	
					$waktu = $this->m_api->get_waktu_by_day($hariIni);
	
					if ($waktu) {
						foreach ($waktu as $key => $value) {
							if ($value->keterangan == 'masuk') {
								$masuk = $value->waktu_operasional;
							}
							if ($value->keterangan == 'keluar') {
								$keluar = $value->waktu_operasional;
							}
						}
					} else {
						$notif = array('status' => 'failed', 'ket' => 'error waktu operasional');
						echo json_encode($notif);
						return;
					}
	
					if (isset($masuk) && isset($keluar)) {
						$masuk = explode("-", $masuk);
						$keluar = explode("-", $keluar);
	
						if (isset($masuk[0]) && isset($masuk[1]) && isset($keluar[0]) && isset($keluar[1])) {
							$masuk1 = strtotime($masuk[0]);
							$masuk2 = strtotime($masuk[1]);
							$keluar1 = strtotime($keluar[0]);
							$keluar2 = strtotime($keluar[1]);
	
							$currentTime = time();
							$absen = false;
							$ket = "";
							$respon = "";
	
							if ($masuk1 > $masuk2) {
								if (($currentTime >= $masuk1 && $currentTime <= strtotime('23:59')) || 
									($currentTime >= strtotime('00:00') && $currentTime <= $masuk2)) {
									$absen = true;
									$ket = "masuk";
									$respon = "MASUK BERHASIL";
								} else {
									$notif = array('status' => 'failed', 'ket' => 'DILUAR WAKTU');
									echo json_encode($notif);
									return;
								}
							} else {
								if ($currentTime >= $masuk1 && $currentTime <= $masuk2) {
									$absen = true;
									$ket = "masuk";
									$respon = "MASUK BERHASIL";
								} else if ($currentTime >= $keluar1 && $currentTime <= $keluar2) {
									$absen = true;
									$ket = "keluar";
									$respon = "KELUAR";
								} else {
									$notif = array('status' => 'failed', 'ket' => 'DILUAR WAKTU');
									echo json_encode($notif);
									return;
								}
							}
	
							if ($absen) {
								$today = strtotime("today");
								$tomorrow = strtotime("tomorrow");
	
								// Fetch attendance data for today
								$datamasuk = $this->m_api->get_absensi("masuk", $today, $tomorrow);
								$datakeluar = $this->m_api->get_absensi("keluar", $today, $tomorrow);
	
								// Ensure $datamasuk and $datakeluar are arrays
								$datamasuk = $datamasuk ?: [];
								$datakeluar = $datakeluar ?: [];
	
								// Merge both arrays
								$datamskKeluar = array_merge($datamasuk, $datakeluar);
	
								$duplicate = 0;
								foreach ($datamskKeluar as $value) {
									if ($value->id_siswa == $id_siswa && $value->keterangan == $ket) {
										$duplicate++;
									}
								}
	
								if ($duplicate == 0) {
									// Insert attendance data
									$data = array(
										'id_devices' => $iddev,
										'id_siswa' => $id_siswa,
										'keterangan' => $ket,
										'created_at' => time()
									);
	
									if ($this->m_api->insert_absensi($data)) {
										// Insert history data
										$histori = array(
											'id_siswa' => $id_siswa,
											'keterangan' => $ket,
											'waktu' => time(),
											'id_devices' => $iddev
										);
										$this->m_api->insert_histori($histori);
	
										$notif = array('status' => 'success', 'ket' => $respon);
										echo json_encode($notif);
									} else {
										$notif = array('status' => 'failed', 'ket' => 'gagal insert absensi');
										echo json_encode($notif);
									}
								} else {
									$notif = array('status' => 'failed', 'ket' => 'SUDAH ABSENSI.');
									echo json_encode($notif);
								}
							} else {
								$notif = array('status' => 'failed', 'ket' => 'error waktu operasional');
								echo json_encode($notif);
							}
						}
					} else {
						$notif = array('status' => 'failed', 'ket' => 'HUBUNGI STAFF');
						echo json_encode($notif);
					}
				} else {
					$notif = array('status' => 'failed', 'ket' => 'ID DEVICE TIDAK DITEMUKAN');
					echo json_encode($notif);
				}
			} else {
				$notif = array('status' => 'failed', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		} else {
			$notif = array('status' => 'failed', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}
	
	public function getmodejson(){
		if (isset($_GET['key']) && isset($_GET['iddev'])) {
			$key = $this->input->get('key');
			$cekkey = $this->m_api->getkey();
			//print_r($cekkey);
			if($cekkey[0]->key == $key){
				$iddev = $this->input->get('iddev');

				$data = $this->m_api->getmode($iddev);
				if (isset($data)) {
					$mode = "-";
					foreach ($data as $key => $value) {
						$mode = $value->mode;
					}
					if ($mode == "-") {
						$array = array('status' => 'warning', 'mode' => $mode, 'ket' => 'id device tidak ditemukan');
						echo json_encode($array);
					}else{
						$array = array('status' => 'success', 'mode' => $mode, 'ket' => 'berhasil');
						echo json_encode($array);
					}
				}else{
					$array = array('status' => 'warning', 'mode' => $mode, 'ket' => 'id device tidak ditemukan');
					echo json_encode($array);
				}
			}else{
				$array = array('status' => 'failed', 'ket' => 'salah secret key');
				echo json_encode($array);
			}
		}else{
			$array = array('status' => 'failed', 'ket' => 'salah parameter');
			echo json_encode($array);
		}
	}


	public function addcardjson(){
		if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['siswa'])) {
			$key = $this->input->get('key');
			$cekkey = $this->m_api->getkey();

			if($cekkey[0]->key == $key){
				$iddev = $this->input->get('iddev');
				$siswa = $this->input->get('siswa');

				$checkDoublesiswa = $this->m_api->checksiswa($siswa);
				$z = 0;
				if (isset($checkDoublesiswa)) {
					foreach ($checkDoublesiswa as $key => $value) {
						$z++;
					}
				}

				if ($z > 0) {
					$notif = array('status' => 'failed', 'ket' => 'siswa TERDAFTAR                           .');
					echo json_encode($notif);
				}else{
					$device = $this->m_api->getdevice($iddev);
					$count = 0;
					foreach ($device as $key => $value) {
						$count++;
					}
					if ($count > 0) {
						$savedata = array('id_devices' => $iddev, 'uid' => $siswa);
						if ($this->m_api->insert_siswa($savedata)) {
							$getlastsiswa = $this->m_api->last_siswa();
							$idsiswa = 0;
							if (isset($getlastsiswa)) {
								foreach ($getlastsiswa as $key => $value) {
									$idsiswa = $value->id_siswa;
								}
							}
							if ($idsiswa > 0) {
								$histori = array('id_siswa' => $idsiswa, 'keterangan' => 'ADD siswa CARD', 'waktu' => time(), 'id_devices' => $iddev);
								if ($this->m_api->insert_histori($histori)) {
									$notif = array('status' => 'success', 'ket' => 'DAFTAR BERHASIL                          .');
									echo json_encode($notif);
								}
							}else{
								$notif = array('status' => 'failed', 'ket' => 'terjadi kesalahan');
								echo json_encode($notif);
							}
						}
					}else{
						$notif = array('status' => 'failed', 'ket' => 'device tidak ditemukan');
						echo json_encode($notif);
					}
				}
			}else{
				$notif = array('status' => 'failed', 'ket' => 'salah secret key');
				echo json_encode($notif);
			}
		}else{
			$notif = array('status' => 'failed', 'ket' => 'salah parameter');
			echo json_encode($notif);
		}
	}

	public function absensijson() {
		if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['siswa'])) {
			$key = $this->input->get('key');
			$cekkey = $this->m_api->getkey();
	
			if ($cekkey[0]->key == $key) {
				$iddev = $this->input->get('iddev');
				$siswa = $this->input->get('siswa');
	
				$ceksiswa = $this->m_api->checksiswa($siswa);
				$countsiswa = 0;
				$idsiswa = 0;
				foreach ($ceksiswa as $key => $value) {
					$countsiswa++;
					$idsiswa = $value->id_siswa;
				}
	
				$device = $this->m_api->getdevice($iddev);
				$count = 0;
				foreach ($device as $key => $value) {
					$count++;
				}
	
				if ($count > 0) {
					if ($countsiswa > 0) {
						$hariIni = date('l');
	
						if ($hariIni == 'Sunday') { 
							$notif = array('status' => 'failed', 'ket' => 'ABSENSI TIDAK TERSEDIA PADA HARI MINGGU');
							echo json_encode($notif);
							return;
						}
	
						
						$waktu = $this->m_api->get_waktu_by_day($hariIni);
	
						if ($waktu) {
							foreach ($waktu as $key => $value) {
								if ($value->keterangan == 'masuk') {
									$masuk = $value->waktu_operasional;
								}
								if ($value->keterangan == 'keluar') {
									$keluar = $value->waktu_operasional;
								}
							}
						} else {
							$notif = array('status' => 'failed', 'ket' => 'error waktu operasional');
							echo json_encode($notif);
							return;
						}
	
						if (isset($masuk) && isset($keluar)) {
							$masuk = explode("-", $masuk);
							$keluar = explode("-", $keluar);
							if (isset($masuk[0]) && isset($masuk[1]) && isset($keluar[0]) && isset($keluar[1])) {
								$masuk1 = strtotime($masuk[0]);
								$masuk2 = strtotime($masuk[1]);
								$keluar1 = strtotime($keluar[0]);
								$keluar2 = strtotime($keluar[1]);
	
								$currentTime = time();
								$absen = false;
								$ket = "";
								$respon = "";
	
								
								if ($masuk1 > $masuk2) { 
								
									if (($currentTime >= $masuk1 && $currentTime <= strtotime('23:59')) || 
										($currentTime >= strtotime('00:00') && $currentTime <= $masuk2)) {
										
										$absen = true;
										$ket = "masuk";
										$respon = "MASUK BERHASIL                        .";
									} else {
										$notif = array('status' => 'failed', 'ket' => 'DILUAR WAKTU                          .');
										echo json_encode($notif);
										return;
									}
								} else {
								
									if ($currentTime >= $masuk1 && $currentTime <= $masuk2) {
										$absen = true;
										$ket = "masuk";
										$respon = "MASUK BERHASIL                        .";
									} else if ($currentTime >= $keluar1 && $currentTime <= $keluar2) {
										$absen = true;
										$ket = "keluar";
										$respon = "KELUAR                             .";
									} else {
										$notif = array('status' => 'failed', 'ket' => 'DILUAR WAKTU                          .');
										echo json_encode($notif);
										return;
									}
								}
	
							
								if ($absen) {
									$today = strtotime("today");
									$tomorrow = strtotime("tomorrow");
	
									$datamasuk = $this->m_api->get_absensi("masuk", $today, $tomorrow);
									$datakeluar = $this->m_api->get_absensi("keluar", $today, $tomorrow);
	
									$duplicate = 0;
	
									if ($datamasuk) {
										foreach ($datamasuk as $key => $value) {
											if ($value->id_siswa == $idsiswa && $value->keterangan == $ket) {
												$duplicate++;
											}
										}
									}
	
									if ($datakeluar) {
										foreach ($datakeluar as $key => $value) {
											if ($value->id_siswa == $idsiswa && $value->keterangan == $ket) {
												$duplicate++;
											}
										}
									}
	
									if ($duplicate == 0) {
										$data = array(
											'id_devices' => $iddev,
											'id_siswa' => $idsiswa,
											'keterangan' => $ket,
											'created_at' => time()
										);
										if ($this->m_api->insert_absensi($data)) {
											$histori = array(
												'id_siswa' => $idsiswa,
												'keterangan' => $ket,
												'waktu' => time(),
												'id_devices' => $iddev
											);
											$this->m_api->insert_histori($histori);
											$notif = array('status' => 'success', 'ket' => $respon);
											echo json_encode($notif);
										} else {
											$notif = array('status' => 'failed', 'ket' => 'gagal insert absensi');
											echo json_encode($notif);
										}
									} else {
										$notif = array('status' => 'failed', 'ket' => 'SUDAH ABSENSI.');
										echo json_encode($notif);
									}
								} else {
									$notif = array('status' => 'failed', 'ket' => 'error waktu operasional');
									echo json_encode($notif);
								}
							}
						} else {
							$notif = array('status' => 'failed', 'ket' => 'HUBUNGI STAFF.');
							echo json_encode($notif);
						}
					} else {
						$notif = array('status' => 'failed', 'ket' => 'id device tidak ditemukan');
						echo json_encode($notif);
					}
				} else {
					$notif = array('status' => 'failed', 'ket' => 'salah secret key');
					echo json_encode($notif);
				}
			}
		}
	}
	
	
}
