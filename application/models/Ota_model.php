<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ota_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function save_firmware($data) {
        return $this->db->insert('firmware_updates', $data);
    }
    
    public function get_latest_firmware() {
        $this->db->order_by('upload_date', 'DESC');
        return $this->db->get('firmware_updates')->row();
    }
}