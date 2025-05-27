<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the DeviceModel
        $this->load->model('DeviceModel');
    }

    public function index() {
        $data['title'] = 'Device Management';
        // Fetch active devices from the model
        $data['devices'] = $this->DeviceModel->get_active_devices();

       
        $this->load->view('device', $data);
       
    }

    public function restart($id = null) {
        // Check if user is logged in and has permission
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        if ($id === null) {
            show_404();
        }

        // Get device details from the model
        $device = $this->DeviceModel->get_device_by_id($id);

        if (!$device) {
            $this->session->set_flashdata('error', 'Device not found');
            redirect('device');
        }

        // Send restart command via API
        $apiKey = "asdkjWEQEDasd12ksnd";
        $response = $this->_sendRestartCommand($device->id_devices, $apiKey);

        if ($response['status'] === 'success') {
            $this->session->set_flashdata('success', 'Restart command sent successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to send restart command: ' . $response['message']);
        }

        redirect('device');
    }

    private function _sendRestartCommand($deviceId, $apiKey) {
        $url = base_url("api/restart?key={$apiKey}&iddev={$deviceId}");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode === 200) {
            return ['status' => 'success'];
        }

        return [
            'status' => 'error',
            'message' => 'HTTP Error: ' . $httpCode
        ];
    }
}
