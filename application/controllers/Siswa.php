<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Picqer\Barcode\BarcodeGeneratorPNG;
class Siswa extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_siswa');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'upload']);
        date_default_timezone_set("Asia/Jakarta");
        
        $this->_check_login();
    }
    private function _check_login() {
        $allowed_methods = ['index', 'siswa'];
        
        if (!in_array($this->router->fetch_method(), $allowed_methods) && !$this->session->userdata('userlogin')) {
            redirect(base_url('login'));
        }
    }
    public function index() {
        $data = [
            'set' => "siswa",
            'siswa' => $this->model_siswa->get_siswa(),
            'title' => 'Data Siswa'
        ];
        
        $this->_render_view('i_siswa', $data);
    }
    public function siswa($method = null) {
        if ($method) {
            $method = strtolower($method);
            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                redirect('dashboard');
            }
        } else {
            redirect('dashboard');
        }
    }
    public function siswanew() {
        $data = [
            'set' => "new",
            'siswa' => $this->model_siswa->get_siswa(),
            'title' => 'Siswa Baru'
        ];
        
        $this->_render_view('i_siswa', $data);
    }
    public function edit_siswa($id = null) {
        if (!$id) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">ID siswa tidak valid</div>');
            redirect('siswa');
            return;
        }
        
        $siswa = $this->model_siswa->get_siswa_byid($id);
        if (empty($siswa)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Siswa tidak ditemukan</div>');
            redirect('siswa');
            return;
        }
        
        $data = (array) $siswa[0];
        $data['kelas'] = !empty($siswa[0]->id_kelas) ? $this->model_siswa->find_kelas($siswa[0]->id_kelas) : null;
        $data['list_kelas'] = $this->model_siswa->get_kelas_byrow();
        $data['set'] = "edit-siswa";
        $data['title'] = 'Edit Data Siswa';
        
        $this->_render_view('i_siswa', $data);
    }
    public function save_edit_siswa() {
        $id = $this->input->post('id');
        $foto = $this->input->post('old_foto');
        
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->_upload_photo();
        }
        
        $update_data = [
            'nama' => $this->input->post('nama'),
            'nisn' => $this->input->post('nisn'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'id_kelas' => $this->input->post('kelas_id'),
            'alamat' => $this->input->post('alamat')
        ];
        if ($foto) {
            $update_data['foto'] = $foto;
        }
        
        if ($this->model_siswa->updatesiswa($id, $update_data)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diupdate</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data gagal diupdate</div>');
        }
        
        redirect('siswa');
    }
    public function delete_siswa($id = null) {
        if (!$id) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">ID siswa tidak valid</div>');
            redirect('siswa');
            return;
        }
        $siswa = $this->model_siswa->get_siswa_byid($id);
        if (!empty($siswa) && !empty($siswa[0]->foto) && $siswa[0]->foto != 'default.jpg') {
            $photo_path = './uploads/' . $siswa[0]->foto;
            if (file_exists($photo_path)) {
                @unlink($photo_path);
            }
        }
        
        if ($this->model_siswa->delete_murid($id)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data siswa berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data siswa gagal dihapus</div>');
        }
        
        redirect('siswa');
    }
    private function _upload_photo() {
        $config = [
            'upload_path' => './uploads/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            
            'file_name' => strtolower(str_replace(' ', '_', $this->input->post('nama'))) . '_' . time()
        ];
        
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            
            $old_foto = $this->input->post('old_foto');
            if ($old_foto && file_exists('./uploads/' . $old_foto) && $old_foto != 'default.jpg') {
                @unlink('./uploads/' . $old_foto);
            }
            
            return $upload_data['file_name'];
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Foto gagal diupload: ' . $this->upload->display_errors('', '') . ' Data lain tetap diupdate.</div>');
            return false;
        }
    }
    private function _render_view($view, $data = []) {
        $data['page_title'] = isset($data['title']) ? $data['title'] : 'Sistem Informasi Siswa';
        
        $this->load->view('include/header', $data);
        $this->load->view($view, $data);
        $this->load->view('include/footer', $data);
    }
    public function detail_murid($id_murid = null) {
        if (!$this->session->userdata('userlogin')) {
         
            return;
        }

        if (!$id_murid) {
            echo "Insert ID murid";
            return;
        }

     
        $this->load->model('model_siswa');

      
        $murid = $this->model_siswa->find_murid($id_murid);

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
}