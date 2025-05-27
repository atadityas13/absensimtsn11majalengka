<?php
class M_data extends CI_Model {

    function get_users(){
        $this->db->select('*');
        $this->db->from('user');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function insert_users($data){
       $this->db->insert('user', $data);
       return TRUE;
    }

    function users_del($id) {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }

 public function delete_murid($id_siswa) {
        // Delete the student from the database based on their siswa ID
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->delete('siswa');  // assuming 'siswa' is your table name
    }
    function updateUser($id,$data){
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);

        return TRUE;
    }

    function get_user_byid($id) {
        $query = $this->db->where('id_user',$id);
        $q = $this->db->get('user');
        $data = $q->result();
        
        return $data;
    }


    function get_devices_byid($id) {
        $query = $this->db->where('id_devices',$id);
        $q = $this->db->get('devices');
        $data = $q->result();
        
        return $data;
    }

    function get_devices(){
        $this->db->select('*');
        $this->db->from('devices');
        $this->db->order_by('id_devices', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    
    function insert_devices($data){
       $this->db->insert('devices', $data);
       return TRUE;
    }

    function devices_del($id) {
        $this->db->where('id_devices', $id);
        $this->db->delete('devices');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
    function updateDevices($id,$data){
        $this->db->where('id_devices', $id);
        $this->db->update('devices', $data);

        return TRUE;
    }


    function empty_data(){
        $this->db->truncate('histori');
        return TRUE;
    }

    function get_siswa(){
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas','kelas.id = siswa.id_kelas','left');
        $this->db->join('kampus','kampus.id = siswa.id_kampus','left');
        $this->db->order_by('id_siswa', 'desc');
        //$this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    

    function get_siswa_byid($id) {
        $query = $this->db->where('id_siswa',$id);
        $q = $this->db->get('siswa');
        $data = $q->result();
        
        return $data;
    }

    function get_siswa_byid_row($id) {
        return $this->db->count_all_results('siswa');

    }

    function updatesiswa($id,$data){
        $this->db->where('id_siswa', $id);
        $this->db->update('siswa', $data);

        return TRUE;
    }

    function siswa_del($id) {
        $this->db->where('id_siswa', $id);
        $this->db->delete('siswa');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }
    
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
   
    

   
    
    function get_history(){
        $this->db->select('*');
        $this->db->from('histori');
        $this->db->join('siswa', 'siswa.id_siswa=histori.id_siswa', 'inner');
        $this->db->join('devices', 'devices.id_devices=histori.id_devices', 'inner');
        $this->db->order_by('id_histori', 'desc');
        $this->db->limit(50);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getkey(){
        $query = $this->db->where('id_key',1);
        $q = $this->db->get('secret_key');
        $data = $q->result();
        
        return $data;
    }



    public function waktuoperasional() {
        $this->db->select('*');
        $this->db->from('waktu_operasional');
        $query = $this->db->get();
        return $query->result();
    }

    // Fungsi untuk memperbarui waktu operasional per hari
    public function update_waktu_operasional($day, $waktu_masuk, $waktu_keluar) {
        // Update waktu masuk
        $this->db->where('day', $day);
        $this->db->where('keterangan', 'masuk');
        $this->db->update('waktu_operasional', ['waktu_operasional' => $waktu_masuk]);

        // Update waktu keluar
        $this->db->where('day', $day);
        $this->db->where('keterangan', 'keluar');
        $this->db->update('waktu_operasional', ['waktu_operasional' => $waktu_keluar]);
    }

    public function find_siswa($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->where('id_siswa',$id_siswa);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return false;
        }


    }
    public function hitung_tidak_absensi() {
        // Mendapatkan semua nama pengguna siswa
        $this->db->select('nama');
        $query = $this->db->get('siswa');
        $siswa_users = $query->result_array();
    
        // Inisialisasi variabel untuk menyimpan jumlah pengguna yang tidak absensi
        $tidak_absensi_count = 0;
    
        // Loop melalui setiap nama pengguna siswa
        foreach ($siswa_users as $user) {
            $nama_pengguna_siswa = $user['nama'];
    
            // Mendapatkan ID siswa berdasarkan nama pengguna siswa
            $this->db->select('id_siswa');
            $this->db->where('nama', $nama_pengguna_siswa);
            $query = $this->db->get('siswa');
            $row = $query->row();
            if ($row) {
                $id_siswa = $row->id_siswa;
    
                // Memeriksa apakah ada entri dalam tabel absensi untuk ID siswa dan tanggal sekarang
                $this->db->where('id_siswa', $id_siswa);
                $this->db->where('DATE(FROM_UNIXTIME(created_at))', date('Y-m-d'));
                // Tambahkan kondisi untuk tidak menghitung data dengan keterangan "keluar"
                $this->db->where('keterangan !=', 'keluar');
                $absensi_count = $this->db->count_all_results('absensi');
    
                // Jika tidak ada entri absensi, maka pengguna dianggap tidak absensi
                if ($absensi_count == 0) {
                    $tidak_absensi_count++;
                }
            }
        }
    
        return $tidak_absensi_count;
    }
    public function get_all_murid() {
        $query = $this->db->get('siswa'); // Replace 'students' with your table name
        return $query->result();
    }
    
    
    public function find_students_by_ids($ids) {
        $this->db->where_in('id_siswa', $ids);
        $query = $this->db->get('siswa'); 
        return $query->result();
    }
    
    public function get_kelas_byrow() {
        return $this->db->get('kelas')->result();
    }
    

    public function get_jam_masuk($id_siswa, $tanggal)
    {
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('keterangan','masuk');
        $this->db->where("created_at >=", $tanggal);
        $this->db->where("created_at <", $tanggal + 86400);

        $query = $this->db->get();

        return $query;
    }

    function get_murid($id_kelas){
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('kelas','kelas.id = siswa.id_kelas','left');
        $this->db->join('kampus','kampus.id = siswa.id_kampus','left');
        $this->db->where('id_kelas',$id_kelas);
        $this->db->order_by("nama", "ASC");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
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

    function insert_kelas($data){
        $this->db->insert('kelas', $data);
        return TRUE;
    }

    public function hapus_kelas($id_kelas)
    {
        $this->db->where('id',$id_kelas);
        $this->db->delete('kelas');

        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;

    }

    function get_kelas(){
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->order_by("id", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }

    }

    function find_kelas($id){
        $this->db->select('*');
        $this->db->from('kelas');
        $this->db->where('id',$id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    
    public function get_holidays($start_date, $end_date) {
        $this->db->where('tanggal >=', date('Y-m-d', $start_date));
        $this->db->where('tanggal <=', date('Y-m-d', $end_date));
        return $this->db->get('libur')->result();
    }

    public function get_all_holidays() {
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('libur')->result();
    }

    public function add_holiday($tanggal, $keterangan) {
        $data = array(
            'tanggal' => $tanggal,
            'keterangan' => $keterangan
        );
        return $this->db->insert('libur', $data);
    }

    public function delete_holiday($id) {
        return $this->db->delete('libur', array('id' => $id));
    }
    public function rekap_absen($id_kelas, $tanggal_mulai, $tanggal_selesai) {
        // Mendapatkan data siswa dalam kelas
        $siswa_kelas = $this->db->where('id_kelas', $id_kelas)->get('siswa')->result();
        
        // Array untuk menyimpan rekap absensi
        $rekap_absen = array();
        
        foreach ($siswa_kelas as $siswa) {
            // Query untuk mendapatkan absensi siswa dalam rentang tanggal yang ditentukan
            $this->db->select('*');
            $this->db->from('absensi');
            $this->db->where('id_siswa', $siswa->id_siswa);
            $this->db->where('created_at >=', $tanggal_mulai);
            $this->db->where('created_at <', $tanggal_selesai);
            $query = $this->db->get();
            $holidays = $this->get_holidays($tanggal_mulai, $tanggal_selesai);

            // Menyimpan hasil query ke dalam array
            $absensi_siswa = $query->result();

            // Menyimpan data siswa dan absensinya ke dalam array rekap absen
            $rekap_absen[] = (object) array(
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
                'absensi' => $absensi_siswa
            );
        }

        return $rekap_absen;
    }
    


    public function get_kampus()
    {
        $this->db->select('*');
        $this->db->from('kampus');
        $this->db->order_by("id", "desc");

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    
    public function hapus_kampus($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('kampus');

        if ($this->db->affected_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function insert_kampus($data)
    {
        $this->db->insert('kampus', $data);
        return TRUE;
     }




    function count_murid($id_kelas){
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->where('id_kelas',$id_kelas);

        $query = $this->db->get();

        return $query->num_rows(); 
    }

   // Fungsi untuk menemukan siswa yang tidak hadir selama 3 hari berturut-turut
public function siswa_tidak_hadir_3_hari_berturut_turut($id_kelas) {
    // Array untuk menyimpan data siswa yang tidak hadir selama 3 hari berturut-turut
    $siswa_tidak_hadir = array();
    
    // Mendapatkan tanggal hari ini
    $today = date('Y-m-d');
    
    // Loop melalui semua siswa dalam kelas
    $siswa_kelas = $this->db->where('id_kelas', $id_kelas)->get('siswa')->result();
    foreach ($siswa_kelas as $siswa) {
        // Hitungan berturut-turut absensi tidak hadir
        $hitungan_tidak_hadir = 0;
        
        // Loop selama 3 hari ke belakang
        for ($i = 0; $i < 3; $i++) {
            $tanggal_cek = date('Y-m-d', strtotime("-$i day", strtotime($today)));
            
            // Periksa apakah siswa tidak hadir pada tanggal ini
            $absensi_siswa = $this->db->where('id_siswa', $siswa->id_siswa)
                                      ->where('DATE(FROM_UNIXTIME(created_at))', $tanggal_cek)
                                      ->where('keterangan', 'absen')
                                      ->get('absensi')
                                      ->row();
            if (!$absensi_siswa) {
                $hitungan_tidak_hadir++;
            } else {
                // Reset hitungan jika siswa hadir pada suatu hari
                $hitungan_tidak_hadir = 0;
            }
        }
        
        // Jika siswa tidak hadir selama 3 hari berturut-turut, tambahkan ke array
        if ($hitungan_tidak_hadir == 3) {
            $siswa_tidak_hadir[] = $siswa;
        }
    }
    
    return $siswa_tidak_hadir;
}




public function get_siswa_by_kelas($kelas_id) {
    return $this->db->where('id_kelas', $kelas_id)->get('siswa')->result();
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

public function hitung_tidak_absensii($kelas_id = null) {
    if ($kelas_id) {
        $this->db->where('id_kelas', $kelas_id);
    }
    $total_siswa = $this->db->count_all_results('siswa');
    
    $this->db->select('DISTINCT(siswa.id_siswa)')
             ->from('absensi')
             ->join('siswa', 'siswa.id_siswa = absensi.id_siswa')
             ->where('created_at >=', strtotime('today'))
             ->where('created_at <=', strtotime('tomorrow'));
    
    if ($kelas_id) {
        $this->db->where('siswa.id_kelas', $kelas_id);
    }
    
    $hadir = $this->db->get()->num_rows();
    return $total_siswa - $hadir;
}


}

?>