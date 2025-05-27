<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fingerprint_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Simpan sidik jari ke database
    public function save_fingerprint($user_id, $fingerprint_data) {
        $data = [
            'user_id' => $user_id,
            'fingerprint_data' => base64_decode($fingerprint_data) // Decode base64 sebelum simpan
        ];
        return $this->db->insert('fingerprints', $data);
    }

    // Ambil semua sidik jari
    public function get_all_fingerprints() {
        return $this->db->get('fingerprints')->result_array();
    }

    // Cek sidik jari
    public function verify_fingerprint($fingerprint_data) {
        $query = $this->db->get('fingerprints')->result_array();
        foreach ($query as $row) {
            if ($row['fingerprint_data'] === base64_decode($fingerprint_data)) {
                return $row['user_id'];
            }
        }
        return false;
    }
}
