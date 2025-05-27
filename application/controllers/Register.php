<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index() {
        $data['kelas'] = $this->Siswa->get_kelas();
        $data['kampus'] = $this->Siswa->get_kampus();
        
        // Set default value for is_success
        $data['is_success'] = $this->session->flashdata('registered') ?? false;
        
        $this->load->view('i_siswa_registration', $data);
    }

    public function submit() {
        $captured_photo = $this->input->post('captured_photo');
        $upload_error = '';
    
        if ($captured_photo) {
            // Handle photo captured from the camera
            $file_name = strtolower(str_replace(' ', '_', $this->input->post('nama'))) . '_' . time() . '.png';
            $file_path = './uploads/' . $file_name;
            $captured_photo = str_replace('data:image/png;base64,', '', $captured_photo);
            $captured_photo = str_replace(' ', '+', $captured_photo);
            $image_data = base64_decode($captured_photo);
            file_put_contents($file_path, $image_data);
        } else {
            // Handle uploaded file
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 0;
            $config['file_name'] = strtolower(str_replace(' ', '_', $this->input->post('nama'))) . '_' . time(); 
    
            $this->upload->initialize($config);
    
            if (!$this->upload->do_upload('foto')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            }
        }
    
        if ($upload_error) {
            $data['kelas'] = $this->Siswa->get_kelas();
            $data['kampus'] = $this->Siswa->get_kampus();
            $data['upload_error'] = $upload_error;
            $this->load->view('i_siswa_registration', $data);
        } else {
            // Process form data
            $data = array(
                'nama' => $this->input->post('nama'),
                'tempat_lahir' => $this->input->post('tempat'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'), 
                'id_kelas' => $this->input->post('id_kelas'),
                'nisn' => $this->input->post('nisn'),
                
                'alamat' => $this->input->post('alamat'),
                'foto' => isset($file_name) ? $file_name : NULL,
            );
    
            $this->Siswa->insert_siswa($data);
    

            $this->session->set_flashdata('registered', true);
    
            // Redirect back to the form
            redirect('register');
        }
    }
}
