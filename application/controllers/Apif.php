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
    public function addcardjson() {
        if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['siswa'])) {
            $key = $this->input->get('key');
            $cekkey = $this->m_api->getkey();

            if($cekkey[0]->key == $key) {
                $iddev = $this->input->get('iddev');
                $fingerID = $this->input->get('siswa');  // fingerID dari sensor

                // Cek apakah fingerID sudah terdaftar
                $checkDouble = $this->m_api->checkFingerprint($fingerID);
                if ($checkDouble) {
                    $notif = array('status' => 'failed', 'ket' => 'FINGERPRINT SUDAH TERDAFTAR');
                    echo json_encode($notif);
                    return;
                }

                $device = $this->m_api->getdevice($iddev);
                if (!$device) {
                    $notif = array('status' => 'failed', 'ket' => 'DEVICE TIDAK DITEMUKAN');
                    echo json_encode($notif);
                    return;
                }

                // Simpan data fingerprint
                $savedata = array(
                    'id_devices' => $iddev,
                    'finger_id' => $fingerID,
                    'registered_at' => date('Y-m-d H:i:s')
                );

                if ($this->m_api->insert_fingerprint($savedata)) {
                    $histori = array(
                        'finger_id' => $fingerID,
                        'keterangan' => 'ADD FINGERPRINT',
                        'waktu' => time(),
                        'id_devices' => $iddev
                    );
                    $this->m_api->insert_histori($histori);
                    
                    $notif = array('status' => 'success', 'ket' => 'PENDAFTARAN BERHASIL');
                    echo json_encode($notif);
                } else {
                    $notif = array('status' => 'failed', 'ket' => 'GAGAL MENYIMPAN DATA');
                    echo json_encode($notif);
                }
            } else {
                $notif = array('status' => 'failed', 'ket' => 'INVALID API KEY');
                echo json_encode($notif);
            }
        } else {
            $notif = array('status' => 'failed', 'ket' => 'PARAMETER TIDAK LENGKAP');
            echo json_encode($notif);
        }
    }

    public function absensijson() {
        if (isset($_GET['key']) && isset($_GET['iddev']) && isset($_GET['siswa'])) {
            $key = $this->input->get('key');
            $cekkey = $this->m_api->getkey();

            if ($cekkey[0]->key == $key) {
                $iddev = $this->input->get('iddev');
                $fingerID = $this->input->get('siswa');  // fingerID dari sensor

                // Cek apakah fingerprint terdaftar
                $siswaData = $this->m_api->getFingerprint($fingerID);
                if (!$siswaData) {
                    $notif = array('status' => 'failed', 'ket' => 'FINGERPRINT TIDAK TERDAFTAR');
                    echo json_encode($notif);
                    return;
                }

                // Proses absensi seperti sebelumnya
                // ... (kode untuk validasi waktu dan proses absensi tetap sama)
                
                if ($absen) {
                    $data = array(
                        'id_devices' => $iddev,
                        'finger_id' => $fingerID,
                        'keterangan' => $ket,
                        'created_at' => time()
                    );
                    
                    if ($this->m_api->insert_absensi($data)) {
                        $histori = array(
                            'finger_id' => $fingerID,
                            'keterangan' => $ket,
                            'waktu' => time(),
                            'id_devices' => $iddev
                        );
                        $this->m_api->insert_histori($histori);
                        
                        $notif = array('status' => 'success', 'ket' => $respon);
                        echo json_encode($notif);
                    }
                }
            }
        }
    }
}