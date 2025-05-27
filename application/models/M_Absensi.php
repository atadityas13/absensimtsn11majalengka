<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Absensi extends CI_Model {

function get_absensi($ket,$today,$tomorrow){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('devices','absensi.id_devices=devices.id_devices','inner');
        $this->db->join('siswa','absensi.id_siswa=siswa.id_siswa','inner');
        $this->db->where("keterangan", $ket);
        $this->db->where("created_at >=", $today);
        $this->db->where("created_at <", $tomorrow);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    public function get_absensii($keterangan, $start, $end, $kelas_id = null) {
        $this->db->select('absensi.*')
                 ->from('absensi')
                 ->join('siswa', 'siswa.id_siswa = absensi.id_siswa')
                 ->where('created_at >=', $start)
                 ->where('created_at <=', $end)
                 ->where('keterangan', $keterangan);
        
        if ($kelas_id) {
            $this->db->where('siswa.id_kelas', $kelas_id);
        }
        
        return $this->db->get()->result();
    }

}