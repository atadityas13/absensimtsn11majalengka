<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Picqer\Barcode\BarcodeGeneratorPNG;

class Cardcontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_data'); 
        date_default_timezone_set("Asia/Jakarta");
        
    }

    public function index() {
        if (!$this->session->userdata('userlogin')) {
           
            redirect('login');
        }

        
        $data['murid'] = $this->m_data->get_all_murid();

      
        $this->load->view('i_kelas_detail', $data);
    }

    public function generate_cards() {
        if (!$this->session->userdata('userlogin')) {
           
            redirect('login');
        }
    
        if ($this->input->post('cetak_semua')) {
            $kelas_id = $this->input->post('kelas_id');
            $students = $this->m_data->get_murid($kelas_id);
        } else {
            $student_ids = $this->input->post('murid_ids');
            if (empty($student_ids)) {
                echo "No students selected";
                return;
            }
            $students = $this->m_data->find_students_by_ids($student_ids);
        }
    
        if (empty($students)) {
            echo "No students found";
            return;
        }
    
        $data = [];
        $generator = new BarcodeGeneratorPNG();
    
        foreach ($students as $student) {
            $barcode = base64_encode($generator->getBarcode($student->uid, $generator::TYPE_CODE_128));
            $data[] = [
                'student' => $student,
                'barcode' => $barcode
            ];
        }
    
      
        $this->load->view('display_cards', ['cards' => $data]);
    }
}
