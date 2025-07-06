<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('penugasan_model');
        
        // Cek login dan role
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        } elseif ($this->session->userdata('peran') != 'kurir') {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_data = $this->session->userdata('user_data');
        $id_kurir = $this->session->userdata('id_kurir'); 
        
        $data['riwayat'] = $this->penugasan_model->get_riwayat_by_kurir($id_kurir);
        $data['title'] = "Riwayat Penugasan - AgriConnect";
        
        $this->load->view('kurir_index/index', $data);
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/riwayat/index', $data);
        $this->load->view('kurir_index/footer');
        
    }
}