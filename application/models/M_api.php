<?php
class M_api extends CI_Model {
        
	function getmode($iddev){
		$query = $this->db->where('id_devices',$iddev);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
	}

	function getkey(){
		$query = $this->db->where('id_key',1);
        $q = $this->db->get('secret_key');
        $data = $q->result();
        
        return $data;
	}

	function getdevice($iddev){
		$query = $this->db->where('id_devices',$iddev);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
	}

	function insert_siswa($data){
		$this->db->insert('siswa', $data);
       return TRUE;
	}

	function last_siswa(){
		$this->db->select('*');
        $this->db->from('siswa');
        $this->db->order_by('id_siswa', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	function insert_histori($data){
		$this->db->insert('histori', $data);
       return TRUE;
	}

	function checksiswa($siswa){
		$query = $this->db->where('uid',$siswa);
        $q = $this->db->get('siswa');
        $data = $q->result();
        
        return $data;
	}

	public function get_waktu_by_day($day) {
        // Daftar hari yang valid
        $valid_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    
        // Periksa apakah $day adalah hari yang valid
        if (!in_array($day, $valid_days)) {
            log_message('error', 'Hari tidak valid: ' . $day);
            return null;  // Mengembalikan null jika hari tidak valid
        }
    
        // Query database jika hari valid
        $this->db->select('*');
        $this->db->from('waktu_operasional');
        $this->db->where('day', $day);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            log_message('error', 'Tidak ada waktu operasional untuk hari: ' . $day);
            return null;  // Mengembalikan null jika tidak ada data
        }
    }
    
    
    function get_siswa_by_id($id_siswa) {
        $query = $this->db->where('id_siswa', $id_siswa);
        $q = $this->db->get('siswa');
        $data = $q->result();
        
        return $data;
    } 
    function insert_absensi($data){
		$this->db->insert('absensi', $data);
       return TRUE;
	}

	function get_absensi($ket,$today,$tomorrow){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where("keterangan", $ket);
        $this->db->where("created_at >=", $today);
        $this->db->where("created_at <", $tomorrow);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function lastsiswafoto($idsiswa){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where("id_siswa", $idsiswa);
        $this->db->order_by('id_absensi', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function update_absensi($id_absensi, $data){
        $this->db->where('id_absensi', $id_absensi);
        $this->db->update('absensi', $data);

        return TRUE;
    }
    function count_absensi_last_two_weeks($id_siswa) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('absensi');
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-2 weeks')));
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->total;
        }
        return 0;
    }
    


}

?>