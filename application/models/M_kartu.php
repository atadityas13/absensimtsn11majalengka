<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kartu extends CI_Model {
    // Get students for a specific class
    public function get_students_by_class($class_id) {
        return $this->db->where('id_kelas', $class_id)->get('siswa')->result();
    }

    // Get all available classes
    public function get_all_kelas() {
        return $this->db->get('kelas')->result();
    }

    // Get class name by ID
    public function get_class_name_by_id($class_id) {
        $result = $this->db->where('id', $class_id)->get('kelas')->row();
        return $result ? $result->kelas : 'unknown_class';
    }

    // Existing method to get all students (keep for backward compatibility)
    public function get_all_murid() {
        return $this->db->get('siswa')->result();
    }
}