<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index() {
        $data['settings'] = $this->settings_model->get_settings();
        $data['title'] = 'Settings App';
        
        $this->load->view('include/header', $data);
        $this->load->view('i_setting_app', $data);
        $this->load->view('include/footer');
    }

    public function update() {
        // Set validation rules
        $this->form_validation->set_rules('app_name', 'Nama Aplikasi', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('school_name', 'Nama Sekolah', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('phone_number', 'Nomor Telepon', 'numeric|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('address', 'Alamat', 'required|min_length[10]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('settings');
            return;
        }

        // Handle logo upload
        $logo_path = null;
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path'] = './uploads/logos/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['max_size'] = 0; // 2MB
            $config['file_name'] = 'logo_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {
                $upload_data = $this->upload->data();
                $logo_path = 'uploads/logos/' . $upload_data['file_name'];

                // Delete old logo if exists
                $old_settings = $this->settings_model->get_settings();
                if ($old_settings && !empty($old_settings['logo_path'])) {
                    $old_file = './' . $old_settings['logo_path'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('settings');
                return;
            }
        }

        // Handle favicon upload
        $favicon_path = null;
        if (!empty($_FILES['favicon']['name'])) {
            $config['upload_path'] = './uploads/favicon/';
            $config['allowed_types'] = 'ico|png';
            $config['max_size'] = 0; // 1MB
            $config['file_name'] = 'favicon_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('favicon')) {
                $upload_data = $this->upload->data();
                $favicon_path = 'uploads/favicon/' . $upload_data['file_name'];

                // Delete old favicon if exists
                $old_settings = $this->settings_model->get_settings();
                if ($old_settings && !empty($old_settings['favicon_path'])) {
                    $old_file = './' . $old_settings['favicon_path'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('settings');
                return;
            }
        }
        $path_template_card = null;
        if (!empty($_FILES['template']['name'])) {
            $config['upload_path'] = './uploads/template/';
            $config['allowed_types'] = 'png';
            $config['max_size'] = 0; 
            $config['file_name'] = 'template_' . time();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('template')) {
                $upload_data = $this->upload->data();
                $path_template_card = 'uploads/template/' . $upload_data['file_name'];

                
                $old_settings = $this->settings_model->get_settings();
                if ($old_settings && !empty($old_settings['path_template_card'])) {
                    $old_file = './' . $old_settings['path_template_card'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('settings');
                return;
            }
        }

        // Prepare data for update
        $data = array(
            'app_name' => $this->input->post('app_name'),
            'school_name' => $this->input->post('school_name'),
            'phone_number' => $this->input->post('phone_number'),
            'address' => $this->input->post('address')
        );

        if ($logo_path) {
            $data['logo_path'] = $logo_path;
        }

        if ($favicon_path) {
            $data['favicon_path'] = $favicon_path;
        }
        if ($path_template_card) {
            $data['path_template_card'] = $path_template_card;
        }

        // Update settings
        if ($this->settings_model->update_settings($data)) {
            $this->session->set_flashdata('success', 'Pengaturan berhasil diupdate');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate pengaturan');
        }

        redirect('settings');
    }
}
