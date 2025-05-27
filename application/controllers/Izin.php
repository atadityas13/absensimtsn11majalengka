<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Izin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Izin_Model');
        $this->load->library('user_agent');
        date_default_timezone_set("asia/jakarta");
    }

    public function index() {
        $data['kelas'] = $this->Izin_Model->get_kelas();
        $data['jumlah_tidak_absensi_per_kelas'] = $this->Izin_Model->get_jumlah_tidak_hadir_per_kelas();
        
        if ($this->agent->is_mobile()) {
            $this->load->view('mobile/i_izin_mobile', $data);
        } else {
            $this->load->view('i_izin', $data);
        }
    }

    public function detail($id_kelas) {
        $data['siswa'] = $this->Izin_Model->get_siswa_by_kelas($id_kelas);
        $data['id_kelas'] = $id_kelas;
        
        // Tambahkan pengecekan status kehadiran untuk setiap siswa
        foreach ($data['siswa'] as $murid) {
            $murid->is_present = $this->Izin_Model->is_present_today($murid->nisn);
        }
        
        if ($this->agent->is_mobile()) {
            $this->load->view('mobile/i_izin_detail_mobile', $data);
        } else {
            $this->load->view('i_izin_detail', $data);
        }
    }

    public function absen() {
        $action = $this->input->post('action');
        $id_kelas = $this->input->post('id_kelas');
        $this->absen_process($action, $id_kelas);
    }

    private function absen_process($action, $id_kelas) {
        $nisn = $this->input->post('nisn');
        $id_devices = $this->input->post('id_devices');
        $tanggal = $this->input->post('tanggal');
    
        $is_registered_nisn = $this->Izin_Model->is_registered_nisn($nisn);
    
        if (!$is_registered_nisn) {
            $data['notification'] = [
                'type' => 'error',
                'message' => 'NISN belum terdaftar. Silakan mendaftar terlebih dahulu.',
                'nisn' => $nisn
            ];
        } else {
            $is_already_absent = $this->Izin_Model->is_already_absent($nisn, $action, $tanggal);
    
            if ($is_already_absent) {
                $data['notification'] = [
                    'type' => 'warning',
                    'message' => 'Siswa sudah melakukan absensi ' . $action . ' pada tanggal ' . $tanggal . '.',
                    'nisn' => $nisn
                ];
            } else {
                if (in_array($action, ['masuk', 'keluar', 'izin', 'sakit'])) {
                    $this->Izin_Model->simpan_absensi($nisn, $id_devices, $action, $tanggal);
                    $data['notification'] = [
                        'type' => 'success',
                        'message' => 'Absensi ' . $action . ' berhasil untuk tanggal ' . $tanggal . '.',
                        'nisn' => $nisn
                    ];
                } else {
                    $data['notification'] = [
                        'type' => 'error',
                        'message' => 'Tindakan absensi tidak valid.',
                        'nisn' => $nisn
                    ];
                }
            }
        }
    
        $data['siswa'] = $this->Izin_Model->get_siswa_by_kelas($id_kelas);
        $data['id_kelas'] = $id_kelas;
        
        // Tambahkan pengecekan status kehadiran untuk setiap siswa
        foreach ($data['siswa'] as $murid) {
            $murid->is_present = $this->Izin_Model->is_present_today($murid->nisn);
        }
        
        if ($this->agent->is_mobile()) {
            $this->load->view('mobile/i_izin_detail_mobile', $data);
        } else {
            $this->load->view('i_izin_detail', $data);
        }
    }}
?>