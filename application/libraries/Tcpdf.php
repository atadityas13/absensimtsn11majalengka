<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tcpdf {
    public function __construct() {
        require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');
    }
}
