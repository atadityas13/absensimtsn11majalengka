<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Picqer\Barcode\BarcodeGeneratorPNG;

class Card extends CI_Controller {
    private $upload_path;
    private $generator;

    public function __construct() {
        parent::__construct();
        $this->load->model('m_kartu');
        $this->load->library(['session', 'zip']);
        
        date_default_timezone_set("Asia/Jakarta");
        
        $this->upload_path = FCPATH . 'uploads/kartu_pelajar/';
        $this->generator = new BarcodeGeneratorPNG();

        // Create directory if not exists
        if (!file_exists($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    private function _check_login() {
        if (!$this->session->userdata('userlogin')) {
            redirect('login');
        }
    }

    private function getTextWidth($pdf, $text) {
        return $pdf->GetStringWidth($text);
    }

    private function writeAlignedText($pdf, $label, $value, $x, $y, $labelWidth = 15, $colonWidth = 2, $valueWidth = 40) {
        $pdf->SetXY($x, $y);
        $pdf->Cell($labelWidth, 4, $label, 0, 0);
        $pdf->Cell($colonWidth, 4, ':', 0, 0);
        
        $valueX = $x + $labelWidth + $colonWidth;
        $pdf->SetXY($valueX, $y);
        
        $pdf->MultiCell($valueWidth, 4, strtoupper($value), 0, 'L');
        
        $lines = max(1, ceil($this->getTextWidth($pdf, $value) / $valueWidth));
        return $lines;
    }

    private function sanitize_filename($filename) {
        $filename = preg_replace('/[^a-zA-Z0-9_.]/', '_', $filename);
        $filename = str_replace(' ', '_', $filename);
        return strtolower($filename);
    }

    private function _create_student_card($student) {
        $pdf = new TCPDF('L', 'mm', array(85.6, 54), true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('School System');
        $pdf->SetTitle('Student ID Card - ' . $student->nama);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AddPage('L', array(85.6, 54));

        // Template Background
        $template_path = FCPATH . get_settings('path_template_card');
        if (file_exists($template_path)) {
            $pdf->Image($template_path, 0, 0, 85.6, 54, '', '', '', false, 300, '', false, false, 0);
        }

        // Barcode
        $barcode = $this->generator->getBarcode($student->nisn, $this->generator::TYPE_CODE_128, 3, 50);
        $pdf->Image('@'.$barcode, 2, 18, 40, 5);

        // Photo
        $photo_path = FCPATH . 'uploads/' . $student->foto;
        if (file_exists($photo_path)) {
            $pdf->Image($photo_path, 5.75, 25, 15, 20, '', '', '', false, 300, '', false, false, 1);
        }

        // Student Information
        $pdf->SetFont('helvetica', 'B', 6);
        $pdf->SetTextColor(0, 0, 0);

        $startX = 25;
        $startY = 25;
        $lineHeight = 4;

        $this->writeAlignedText($pdf, 'Nama', $student->nama, $startX, $startY);
        $this->writeAlignedText($pdf, 'TTL', $student->tempat_lahir . ',' . $student->tanggal_lahir, $startX, $startY + ($lineHeight * 1));
        $this->writeAlignedText($pdf, 'NISN', $student->nisn, $startX, $startY + ($lineHeight * 2));
        $this->writeAlignedText($pdf, 'Alamat', $student->alamat, $startX, $startY + ($lineHeight * 3));

        return $pdf;
    }

    public function generate_cards() {
        $this->_check_login();

        $students = $this->m_kartu->get_all_murid();
        $data = [];

        foreach ($students as $student) {
            $barcode = base64_encode($this->generator->getBarcode($student->nisn, $this->generator::TYPE_CODE_128, 3, 50));
            $data[] = [
                'student' => $student,
                'barcode' => $barcode
            ];
        }

        $this->load->view('display_cards', ['cards' => $data]);
    }

    public function cetak_kartu() {
        $this->_check_login();
        $data['classes'] = $this->m_kartu->get_all_kelas();
        $this->load->view('i_card', $data);
    }

    public function download_cards() {
        $this->_check_login();
        $students = $this->m_kartu->get_all_murid();

        $zip_name = 'kartu_pelajar_' . date('Y-m-d_H-i-s') . '.zip';
        $zip_path = $this->upload_path . $zip_name;

        try {
            $this->load->library('zip');
            
            foreach ($students as $student) {
                $pdf = $this->_create_student_card($student);
                $filename = $this->sanitize_filename($student->nama) . '.pdf';
                
                $pdf_content = $pdf->Output('', 'S');
                $this->zip->add_data($filename, $pdf_content);
            }

            $this->zip->archive($zip_path);
            $this->_force_download($zip_path);
        } catch (Exception $e) {
            log_message('error', 'Card Generation Error: ' . $e->getMessage());
            show_error('Gagal membuat kartu pelajar');
        }
    }

    public function download_class_cards() {
        $this->_check_login();
        $class_id = $this->input->post('kelas');
        
        if (empty($class_id)) {
            $this->session->set_flashdata('error', 'Pilih kelas terlebih dahulu');
            redirect('card/cetak_kartu');
        }

        $students = $this->m_kartu->get_students_by_class($class_id);
        $class_name = $this->m_kartu->get_class_name_by_id($class_id);

        $zip_name = 'kartu_pelajar_' . $this->sanitize_filename($class_name) . '_' . date('Y-m-d_H-i-s') . '.zip';
        $zip_path = $this->upload_path . $zip_name;

        try {
            $this->load->library('zip');
            
            foreach ($students as $student) {
                $pdf = $this->_create_student_card($student);
                $filename = $this->sanitize_filename($student->nama) . '.pdf';
                
                $pdf_content = $pdf->Output('', 'S');
                $this->zip->add_data($filename, $pdf_content);
            }

            $this->zip->archive($zip_path);
            $this->_force_download($zip_path);
        } catch (Exception $e) {
            log_message('error', 'Class Card Generation Error: ' . $e->getMessage());
            show_error('Gagal membuat kartu pelajar kelas');
        }
    }

    private function _force_download($filepath) {
        if (file_exists($filepath)) {
            $filename = basename($filepath);
            
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            
            // Clean up
            unlink($filepath);
            exit;
        }
    }
}