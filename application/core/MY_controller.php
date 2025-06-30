<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->check_login();
    }

    protected function check_login() {
        // Daftar controller yang tidak perlu login
        $allowed_controllers = ['auth'];
        
        // Dapatkan nama controller saat ini
        $class = $this->router->fetch_class();
        
        // Periksa apakah pengguna sudah login
        if (!$this->session->userdata('isLoggedIn') && !in_array($class, $allowed_controllers)) {
            redirect('auth/login');
        }
    }
    
    protected function check_role($roles) {
        if (!in_array($this->session->userdata('peran'), $roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini');
            redirect('dashboard');
        }
    }
}