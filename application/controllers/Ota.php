<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ota extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('ota_model');
        $this->load->helper(['url', 'form', 'file']);
        $this->load->library('upload');
    }
    
    public function index() {
        $data['title'] = 'ESP32 OTA Update';
        $data['firmware'] = $this->ota_model->get_latest_firmware();
        $this->load->view('include/header', $data);
        $this->load->view('ota/index', $data);
        $this->load->view('include/footer', $data);
    }
    
    public function upload() {
        // Validasi input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('version', 'Version', 'required|regex_match[/^\d+\.\d+\.\d+$/]');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('ota');
            return;
        }
        
        // Konfigurasi upload
        $upload_path = FCPATH . 'uploads/ota/';
        
        // Pastikan direktori ada dan writable
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        
        $config = [
            'upload_path' => $upload_path,
            'allowed_types' => '*',  // Hanya izinkan file .bin
            'max_size' => 2048,  // 2MB max
            'overwrite' => TRUE,
            'file_ext_tolower' => TRUE,
            'file_name' => 'firmware_' . $this->input->post('version') . '.bin'
        ];
        
        $this->upload->initialize($config);
        
        if (!$this->upload->do_upload('firmware')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            log_message('error', 'Firmware upload failed: ' . $error);
        } else {
            $upload_data = $this->upload->data();
            
            // Verifikasi file adalah binary firmware yang valid
            if (!$this->validate_firmware($upload_data['full_path'])) {
                unlink($upload_data['full_path']);
                $this->session->set_flashdata('error', 'Invalid firmware file');
                redirect('ota');
                return;
            }
            
            $data = [
                'filename' => $upload_data['file_name'],
                'version' => $this->input->post('version'),
                'description' => $this->input->post('description'),
                'file_size' => $upload_data['file_size'],
                'file_hash' => hash_file('sha256', $upload_data['full_path']),
                'upload_date' => date('Y-m-d H:i:s')
            ];
            
            $this->ota_model->save_firmware($data);
            $this->session->set_flashdata('success', 'Firmware berhasil diupload');
            
            log_message('info', 'New firmware uploaded: ' . json_encode($data));
        }
        
        redirect('ota');
    }
    
    public function check_update() {
        // Set headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        
        try {
            $currentVersion = $this->input->get('version');
            
            // Validasi format versi
            if (!preg_match('/^\d+\.\d+\.\d+$/', $currentVersion)) {
                throw new Exception('Invalid version format');
            }
            
            $firmware = $this->ota_model->get_latest_firmware();
            
            if (!$firmware) {
                $this->send_json_response('error', 'No firmware available');
                return;
            }
            
            log_message('debug', "Check update - Current version: $currentVersion, Latest version: {$firmware->version}");
            
            // Bandingkan versi
            if (version_compare($currentVersion, $firmware->version, '>=')) {
                $this->send_json_response('no_update', null, $firmware->version);
                return;
            }
            
            // Verifikasi file firmware ada
            $firmware_path = FCPATH . 'uploads/ota/' . $firmware->filename;
            if (!file_exists($firmware_path)) {
                log_message('error', "Firmware file not found: {$firmware_path}");
                $this->send_json_response('error', 'Firmware file not found');
                return;
            }
            
            $response = [
                'status' => 'success',
                'version' => $firmware->version,
                'filename' => base_url('uploads/ota/' . $firmware->filename),
                'size' => filesize($firmware_path),
                'hash' => hash_file('sha256', $firmware_path)
            ];
            
            log_message('info', 'Update available - Response: ' . json_encode($response));
            echo json_encode($response);
            
        } catch (Exception $e) {
            log_message('error', 'Update check failed: ' . $e->getMessage());
            $this->send_json_response('error', $e->getMessage());
        }
    }
    
    private function validate_firmware($file_path) {
        // Validasi ukuran minimal
        if (filesize($file_path) < 1024) { // Minimal 1KB
            return false;
        }
        
        // Baca header file untuk memastikan ini adalah binary ESP32
        $handle = fopen($file_path, 'rb');
        if ($handle) {
            $header = fread($handle, 4);
            fclose($handle);
            
            // ESP32 firmware biasanya dimulai dengan magic number E9
            return (bin2hex($header[0]) == 'e9');
        }
        
        return false;
    }
    
    private function send_json_response($status, $message = null, $version = null) {
        $response = ['status' => $status];
        
        if ($message) {
            $response['message'] = $message;
        }
        
        if ($version) {
            $response['version'] = $version;
        }
        
        echo json_encode($response);
    }
}

