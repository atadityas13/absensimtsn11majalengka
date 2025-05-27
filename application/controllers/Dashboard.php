<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->library('user_agent');
        date_default_timezone_set("Asia/Jakarta");
    }
    
    public function index() {
        $data['set'] = "dashboard";
        $data['siswa'] = $this->m_data->get_siswa();
        $data['devices'] = $this->m_data->get_devices();
        $data['kelas'] = $this->m_data->get_kelas_byrow();
        
        $selected_class = $this->input->get('kelas_id');
        $months_range = $this->input->get('months_range') ?: 6;
        
        $data['masuk'] = $this->m_data->get_absensii("masuk", strtotime("today"), strtotime("tomorrow"), $selected_class);
        $data['keluar'] = $this->m_data->get_absensii("keluar", strtotime("today"), strtotime("tomorrow"), $selected_class);
        $data['izin'] = $this->m_data->get_absensii("izin", strtotime("today"), strtotime("tomorrow"), $selected_class);
        $data['sakit'] = $this->m_data->get_absensii("sakit", strtotime("today"), strtotime("tomorrow"), $selected_class);
        
        $data['jumlah_tidak_absensi'] = $this->m_data->hitung_tidak_absensii($selected_class);
        
        $data['jmlsiswa'] = is_array($data['siswa']) ? count($data['siswa']) : 0;
        $data['jmlalat'] = is_array($data['devices']) ? count($data['devices']) : 0;
        $data['jmlmasuk'] = is_array($data['masuk']) ? count($data['masuk']) : 0;
        $data['jmlkeluar'] = is_array($data['keluar']) ? count($data['keluar']) : 0;
        $data['jmlizin'] = is_array($data['izin']) ? count($data['izin']) : 0;
        $data['jmlsakit'] = is_array($data['sakit']) ? count($data['sakit']) : 0;
        $data['jumlah_tidak_absensi'] = is_numeric($data['jumlah_tidak_absensi']) ? $data['jumlah_tidak_absensi'] : 0;
    
        $data['selected_class'] = $selected_class;
        $data['months_range'] = $months_range;
        
        $pie_chart = [
            ['label' => 'Masuk', 'data' => $data['jmlmasuk'], 'color' => '#28a745'],
            ['label' => 'Izin', 'data' => $data['jmlizin'], 'color' => '#ffc107'],
            ['label' => 'Sakit', 'data' => $data['jmlsakit'], 'color' => '#17a2b8'],
            ['label' => 'Tidak Hadir', 'data' => $data['jumlah_tidak_absensi'], 'color' => '#dc3545']
        ];
        
        $monthly_stats = $this->_get_monthly_stats($selected_class, $months_range);
        
        $data['chart_data'] = [
            'pie_chart' => $pie_chart,
            'combine_chart' => $monthly_stats
        ];
        
        if ($this->agent->is_mobile()) {
            $this->load->view('mobile/i_mobile_dashboard', $data);
        } else {
            $this->load->view('include/header', $data);
            $this->load->view('i_dashboard', $data);
            $this->load->view('include/footer', $data);
        }
    }
    
    private function _get_monthly_stats($selected_class = null, $months_range = 6) {
        $months = [];
        $masuk_data = [];
        $izin_data = [];
        $sakit_data = [];
        $tidak_hadir_data = [];
    
        for ($i = ($months_range - 1); $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $months[] = date('M Y', strtotime($month));
            
            $start_date = strtotime(date('Y-m-01', strtotime($month)));
            $end_date = strtotime(date('Y-m-t', strtotime($month)));
            
            $where_class = $selected_class ? "AND siswa.id_kelas = $selected_class" : "";
            
            $siswa = $selected_class ? 
                $this->db->where('id_kelas', $selected_class)->get('siswa')->result() : 
                $this->m_data->get_siswa();
            $total_siswa = is_array($siswa) ? count($siswa) : 0;
    
            $query_masuk = $this->db->query("
                SELECT DISTINCT(siswa.id_siswa)
                FROM absensi
                JOIN siswa ON siswa.id_siswa = absensi.id_siswa
                WHERE absensi.created_at >= $start_date 
                AND absensi.created_at <= $end_date
                AND absensi.keterangan = 'masuk'
                $where_class
            ");
            $masuk_count = $query_masuk->num_rows();
    
            $query_izin = $this->db->query("
                SELECT DISTINCT(siswa.id_siswa)
                FROM absensi
                JOIN siswa ON siswa.id_siswa = absensi.id_siswa
                WHERE absensi.created_at >= $start_date 
                AND absensi.created_at <= $end_date
                AND absensi.keterangan = 'izin'
                $where_class
            ");
            $izin_count = $query_izin->num_rows();
    
            $query_sakit = $this->db->query("
                SELECT DISTINCT(siswa.id_siswa)
                FROM absensi
                JOIN siswa ON siswa.id_siswa = absensi.id_siswa
                WHERE absensi.created_at >= $start_date 
                AND absensi.created_at <= $end_date
                AND absensi.keterangan = 'sakit'
                $where_class
            ");
            $sakit_count = $query_sakit->num_rows();
            
            $hadir_total = $masuk_count + $izin_count + $sakit_count;
            $tidak_hadir = $total_siswa - $hadir_total;
            
            $masuk_data[] = $masuk_count;
            $izin_data[] = $izin_count;
            $sakit_data[] = $sakit_count;
            $tidak_hadir_data[] = max(0, $tidak_hadir);
        }
        
        return [
            'months' => $months,
            'series' => [
                ['name' => 'Masuk', 'data' => $masuk_data, 'color' => '#28a745'],
                ['name' => 'Izin', 'data' => $izin_data, 'color' => '#ffc107'],
                ['name' => 'Sakit', 'data' => $sakit_data, 'color' => '#17a2b8'],
                ['name' => 'Tidak Hadir', 'data' => $tidak_hadir_data, 'color' => '#dc3545']
            ]
        ];
    }
}
