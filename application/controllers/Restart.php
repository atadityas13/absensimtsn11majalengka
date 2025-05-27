
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restart extends CI_Controller {
    
    public function index() {
        // Validate API key
        $key = $this->input->get('key');
        $iddev = $this->input->get('iddev');
        
        if ($key !== 'asdkjWEQEDasd12ksnd') {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Invalid API key'
                ]));
            return;
        }
        
        // Get device details
        $device = $this->db->get_where('devices', ['id_devices' => $iddev])->row();
        
        if (!$device) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Device not found'
                ]));
            return;
        }
        
        // Update device status to pending restart
        $this->db->where('id', $iddev)
                 ->update('devices', ['restart_pending' => 1]);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'command' => 'restart'
            ]));
    }
}