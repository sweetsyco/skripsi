<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurir extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penugasan_model');
        $this->load->model('petani_model');
        $this->load->model('penawaran_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'petani') {
            redirect('auth/login');
        }
    }

    public function index() {
        $id_pengguna = $this->session->userdata('user_id');
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        $data['title'] = "List Penugasan - AgriConnect";
        
        if(empty($data['petani'])) {
            show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
        }
        
        $id_petani = $data['petani']['id_petani'];
        $data['penugasan'] = $this->penugasan_model->get_penugasan_by_petani($id_petani);
        
        $this->load->view('petani_index/index',$data);
        $this->load->view('petani_index/header');
        $this->load->view('petani/kurir/index', $data);
        $this->load->view('petani_index/kurir_footer');
    }

    public function detail($id_penugasan) {
        $data['penugasan'] = $this->penugasan_model->get_detail_penugasan($id_penugasan);
        
        if (!$data['penugasan']) {
            show_404();
        }

        $data['title'] = 'Detail Penugasan Kurir';
        
        $this->load->view('petani_index/index',$data);
        $this->load->view('petani_index/header');
        $this->load->view('petani/kurir/detail', $data);
        $this->load->view('petani_index/kurir_footer');
    }
}