<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Absensi');
        date_default_timezone_set("asia/jakarta");
    }

    public function index() {
        $data['set'] = "absensi";
        $today = strtotime("today");
        $tomorrow = strtotime("tomorrow");
        $data['absensimasuk'] = $this->M_Absensi->get_absensi("masuk", $today, $tomorrow);
        $data['absensikeluar'] = $this->M_Absensi->get_absensi("keluar", $today, $tomorrow);
        $data['M_Absensi'] = $this->M_Absensi;
        $this->load->view('i_absensi', $data);
    }

    public function sse_updates() {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $lastUpdate = 0;

        while (true) {
            $today = strtotime("today");
            $tomorrow = strtotime("tomorrow");

            $absensimasuk = $this->M_Absensi->get_absensi("masuk", $today, $tomorrow);
            $absensikeluar = $this->M_Absensi->get_absensi("keluar", $today, $tomorrow);

            $latestUpdate = max(
                array_reduce($absensimasuk, function($carry, $item) {
                    return max($carry, $item->created_at);
                }, 0),
                array_reduce($absensikeluar, function($carry, $item) {
                    return max($carry, $item->created_at);
                }, 0)
            );

            if ($latestUpdate > $lastUpdate) {
                $lastUpdate = $latestUpdate;

                // Add kelas information to each entry
                foreach ($absensimasuk as &$row) {
                    $row->kelas = ($row->id_kelas != null) ? $this->M_Absensi->find_kelas($row->id_kelas)->kelas : "-";
                }
                foreach ($absensikeluar as &$row) {
                    $row->kelas = ($row->id_kelas != null) ? $this->M_Absensi->find_kelas($row->id_kelas)->kelas : "-";
                }

                $data = json_encode([
                    'absensimasuk' => $absensimasuk,
                    'absensikeluar' => $absensikeluar
                ]);

                echo "data: $data\n\n";
                ob_flush();
                flush();
            }

            // Sleep for a short time before checking for updates again
            sleep(3);
        }
    }

    public function lastabsensi() {
        if($this->session->userdata('userlogin')) {
            if (isset($_POST['tanggal'])) {
                $tgl = $this->input->post('tanggal');
                $split1 = explode("-", $tgl);
                $x = 0;
                foreach ($split1 as $key => $value) {
                    $date[$x] = $value;
                    $x++;
                }

                $ts1 = strtotime($date[0]);
                $ts2 = strtotime($date[1]);

                $tgl1 = date("d-M-Y",$ts1);
                $tgl2 = date("d-M-Y",$ts2);

                $ts2 += 86400;

                if ($x==2) {
                    $data['datamasuk'] = $this->M_Absensi->get_absensi("masuk",$ts1,$ts2);
                    $data['datakeluar'] = $this->M_Absensi->get_absensi("keluar",$ts1,$ts2);
                    $data['tanggal'] = $tgl1 . " - " . $tgl2;
                    $data['waktuabsensi'] = $tgl1 . "_" . $tgl2;

                    $data['set'] = "last-absensi";
                    
                    $data['M_Absensi'] = $this->M_Absensi;

                    $this->load->view('v_absensi', $data);
                } else {
                    redirect(base_url().'absensi');
                }                
            } else {
                redirect(base_url().'absensi');
            }
        }
    }
}