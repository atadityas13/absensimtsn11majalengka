<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {
    private $table = 'app_settings';

    public function __construct() {
        parent::__construct();
    }

    public function get_settings() {
        return $this->db->get($this->table)->row_array();
    }
    public function get_latest_firmware() {
        return $this->db->order_by('upload_date', 'DESC')->get('firmware')->row();
    }

    public function update_settings($data) {
        $existing = $this->get_settings();
        
        if ($existing) {
            return $this->db->update($this->table, $data, ['id' => $existing['id']]);
        } else {
            return $this->db->insert($this->table, $data);
        }
    }
}