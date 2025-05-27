<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_siswa extends CI_Model {
    public function get_siswa() {
        $this->db->select('siswa.*, kelas.id as kelas_id, kelas.kelas, kampus as kampus');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
        $this->db->join('kampus', 'kampus.id = siswa.id_kampus', 'left');
        $this->db->order_by('id_siswa', 'desc');
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->result() : [];
    }
    public function get_siswa_byid($id) {
        $this->db->where('id_siswa', $id);
        $query = $this->db->get('siswa');
        
        return ($query->num_rows() > 0) ? $query->result() : [];
    }
    public function updatesiswa($id, $data) {
        $this->db->where('id_siswa', $id);
        return $this->db->update('siswa', $data);
    }
    public function delete_murid($id_siswa) {
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->delete('siswa');
    }
    public function get_kelas_byrow() {
        return $this->db->get('kelas')->result();
    }
    public function find_kelas($id) {
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query->row() : null;
    }
    public function get_kelas() {
        return $this->get_kelas_byrow();
    }
    public function find_murid($id_murid)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas','kelas.id = siswa.id_kelas','left');
        $this->db->join('kampus','kampus.id = siswa.id_kampus','left');
        $this->db->where('id_siswa',$id_murid);
        $this->db->order_by("nama", "ASC");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
}