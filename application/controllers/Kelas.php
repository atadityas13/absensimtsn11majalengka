<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Picqer\Barcode\BarcodeGeneratorPNG;

class Kelas extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->library('user_agent');
        date_default_timezone_set("asia/jakarta");
    }

    public function index(){
		if(!$this->session->userdata('userlogin'))    
		{
			return ;
		}

		if(isset($_POST['kelas'])){
			$kelas = [
				'kelas' => $_POST['kelas']
			];

			$this->m_data->insert_kelas($kelas);

			$data['message'] = "Berhasil menambahkan kelas"; 
			
		}

		$data['kelas'] = $this->m_data->get_kelas();

		$data['m_data'] = $this->m_data;

		$this->load->view('i_kelas', $data);

	}
    
    public function detail_murid($id_murid = null) {
        if (!$this->session->userdata('userlogin')) {
         
            return;
        }

        if (!$id_murid) {
            echo "Insert ID murid";
            return;
        }

     
        $this->load->model('m_data');

      
        $murid = $this->m_data->find_murid($id_murid);

        if (!$murid) {
            echo "Murid tidak ditemukan";
            return;
        }

    
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($murid[0]->nisn, $generator::TYPE_CODE_128));

    
        $this->load->view('i_detail_murid', [
            "murid" => $murid[0],
            "barcode" => $barcode
        ]);
    }
	public function tambah_kelas(){
		if(!$this->session->userdata('userlogin'))   
		{
			return ;
		}

	}
	public function lihat_kelas() {
		if(!$this->session->userdata('userlogin')) {
			redirect(base_url('login'));
			return;
		}
	
		// Validasi id_kelas
		$id_kelas = $this->input->get('id_kelas');
		if(!$id_kelas) {
			$this->session->set_flashdata('error', 'ID Kelas tidak ditemukan');
			redirect(base_url('kelas'));
			return;
		}
	
		// Ambil data kelas
		$kelas = $this->m_data->find_kelas($id_kelas);
		if(!$kelas) {
			$this->session->set_flashdata('error', 'Data kelas tidak ditemukan');
			redirect(base_url('kelas'));
			return;
		}
	
		// Ambil data murid
		$murid = $this->m_data->get_murid($id_kelas);
		
		$data = [
			'kelas' => $kelas,
			'murid' => $murid
		];
	
		$this->load->view('i_kelas_detail', $data);
	}
	public function hapus_kelas()
{
    if (!$this->session->userdata('userlogin')) {
        redirect(base_url('login'));
        return;
    }

    $id_kelas = $this->input->get('id_kelas');

    if (!$id_kelas) {
        show_error('ID Kelas tidak ditemukan!', 400);
        return;
    }

    $this->m_data->hapus_kelas($id_kelas);
    
    redirect(base_url('kelas'));
}

    public function rekap_absen($id_kelas = null)
    {
        if(!$this->session->userdata('userlogin'))
        {
            return ;
        }

        if(!$id_kelas){
            echo "insert id kelas";
            return;
        }

        $kelas = $this->m_data->find_kelas($id_kelas);

        if (!$kelas) {
            echo "kelas tidak ditemukan";
            return;
        }

        $rekap_absen = [];
        if (isset($_GET["tanggalMulai"]) && isset($_GET["tanggalSelesai"])) {
            $tanggal_mulai = strtotime($this->input->get('tanggalMulai'));
            $tanggal_selesai = strtotime($this->input->get('tanggalSelesai')) + 86400; // Tambah 1 hari

            $rekap_absen = $this->m_data->rekap_absen($id_kelas, $tanggal_mulai, $tanggal_selesai);

            // Fetch holidays
            $holidays = $this->m_data->get_holidays($tanggal_mulai, $tanggal_selesai);
        }

        $this->load->view('i_detail_absen', [
            "kelas" => $kelas,
            "rekap_absen" => $rekap_absen,
            "holidays" => isset($holidays) ? $holidays : [],
        ]);
    }
    public function manage_holidays()
    {
        if(!$this->session->userdata('userlogin'))
        {
            return ;
        }

        if($this->input->post()) {
            $tanggal = $this->input->post('tanggal');
            $keterangan = $this->input->post('keterangan');
            
            $this->m_data->add_holiday($tanggal, $keterangan);
            $this->session->set_flashdata('success', 'Hari libur berhasil ditambahkan');
            redirect('kelas/manage_holidays');
        }

        $holidays = $this->m_data->get_all_holidays();

        // Check if the user is on a mobile device
        if ($this->agent->is_mobile()) {
            $this->load->view('mobile/i_manage_holidays_mobile', ['holidays' => $holidays]);
        } else {
            $this->load->view('i_manage_holidays', ['holidays' => $holidays]);
        }
    }
    public function hapus_murid($id=null){
		if($this->session->userdata('userlogin'))    
		{ 
			if($this->m_data->siswa_del($id)){
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil di hapus</div>");
			}else{
				$this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal di hapus</div>");
			}
			redirect('kelas/lihat_kelas?id_kelas=' . $this->input->post('id_kelas'));
		}
	}
    public function delete_holiday($id)
    {
        if(!$this->session->userdata('userlogin'))
        {
            return ;
        }

        $this->m_data->delete_holiday($id);
        $this->session->set_flashdata('success', 'Hari libur berhasil dihapus');
        redirect('kelas/manage_holidays');
    }
    public function edit_siswa($id = null) {
		if ($this->session->userdata('userlogin')) { 
			if (isset($id)) {
				$siswa = $this->m_data->get_siswa_byid($id);
				if (isset($siswa)) {
					foreach ($siswa as $key => $value) {
						$data['id'] = $value->id_siswa;
						$data['nama'] = $value->nama;
						$data['nisn'] = $value->nisn;
						
						$data['tempat_lahir'] = $value->tempat_lahir;
						$data['tanggal_lahir'] = $value->tanggal_lahir;
						$data['kelas'] = $value->id_kelas != null ? $this->m_data->find_kelas($value->id_kelas) : null;
						$data['alamat'] = $value->alamat;
						$data['foto'] = $value->foto;
					}
	
					$data['list_kelas'] = $this->m_data->get_kelas();
	
					$this->load->view('i_edit_siswa', $data);
				} else {
					redirect('kelas/lihat_kelas?id_kelas=' . $this->input->post('kelas_id'));
				}
			} else {
				redirect('kelas/lihat_kelas?id_kelas=' . $this->input->post('kelas_id'));
			}
		} else {
			redirect(base_url() . 'login');
		}
	}
	
	public function save_edit_siswa() {
		if ($this->session->userdata('userlogin')) { 
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				
				// Inisialisasi variabel foto
				$foto = $this->input->post('old_foto');
				
				// Handle file upload if a new photo is provided
				if (!empty($_FILES['foto']['name'])) {
					// Buat direktori upload jika belum ada
					if (!is_dir('./uploads/')) {
						mkdir('./uploads/', 0777, true);
					}
	
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = '*'; // Mengizinkan semua tipe file
					$config['file_name'] = strtolower(str_replace(' ', '_', $this->input->post('nama'))) . '_' . time();
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					if ($this->upload->do_upload('foto')) {
						$upload_data = $this->upload->data();
						$foto = $upload_data['file_name'];
						
						// Hapus foto lama jika ada dan bukan foto default
						$old_foto = $this->input->post('old_foto');
						if ($old_foto && file_exists('./uploads/' . $old_foto) && $old_foto != 'default.jpg') {
							@unlink('./uploads/' . $old_foto);
						}
					} else {
						// Jika upload gagal, tampilkan pesan error tapi tetap lanjut update data lain
						$error = $this->upload->display_errors();
						if (strpos($error, 'upload_path_does_not_exist') !== false) {
							// Coba buat direktori jika belum ada
							mkdir('./uploads/', 0777, true);
							// Coba upload lagi
							if ($this->upload->do_upload('foto')) {
								$upload_data = $this->upload->data();
								$foto = $upload_data['file_name'];
							} else {
								$this->session->set_flashdata('pesan', '<div class="alert alert-warning" id="alert"><i class="glyphicon glyphicon-warning-sign"></i> Foto gagal diupload. Data lain tetap diupdate.</div>');
								$foto = $this->input->post('old_foto');
							}
						} else {
							$this->session->set_flashdata('pesan', '<div class="alert alert-warning" id="alert"><i class="glyphicon glyphicon-warning-sign"></i> Foto gagal diupload. Data lain tetap diupdate.</div>');
							$foto = $this->input->post('old_foto');
						}
					}
				}
	
				$update_data = array(
					'nama' => $this->input->post('nama'),
					'nisn' => $this->input->post('nisn'),
					
					'tempat_lahir' => $this->input->post('tempat_lahir'),
					'tanggal_lahir' => $this->input->post('tanggal_lahir'),
					'id_kelas' => $this->input->post('kelas_id'),
					'alamat' => $this->input->post('alamat'),
					'foto' => $foto
				);
	
				if ($this->m_data->updatesiswa($id, $update_data)) {
					$this->session->set_flashdata('pesan', '<div class="alert alert-success" id="alert"><i class="glyphicon glyphicon-ok"></i> Data berhasil diupdate</div>');
				} else {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" id="alert"><i class="glyphicon glyphicon-remove"></i> Data gagal diupdate</div>');
				}
	
				redirect('kelas/lihat_kelas?id_kelas=' . $this->input->post('kelas_id'));
			} else {
				$this->session->set_flashdata('error', 'ID tidak ditemukan.');
				redirect('siswa');
			}
		} else {
			redirect(base_url() . 'login');
		}
	}
}