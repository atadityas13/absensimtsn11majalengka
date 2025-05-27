<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_settings')) {
    function get_settings($key = null) {
        $CI =& get_instance();
        $CI->load->model('settings_model');
        
        $settings = $CI->settings_model->get_settings();
        
        if ($key !== null) {
            return isset($settings[$key]) ? $settings[$key] : null;
        }
        
        return $settings;
    }
}