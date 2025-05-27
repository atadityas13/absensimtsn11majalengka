<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Ensure database is loaded
    }

    // Fetch all active devices (where status is 1)
    public function get_active_devices() {
        $query = $this->db->get_where('devices', ['status' => 1]);
        return $query->result();
    }

    // Fetch a single device by its ID
    public function get_device_by_id($id_devices) {
        $query = $this->db->get_where('devices', ['id_devices' => $id_devices]);
        return $query->row();
    }
}
