<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('petani_model');
        
        // Cek login dan peran
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'petani') {
            redirect('auth/login');
        }
    }

    public function index() {
        // Ambil data dari session
        $id_pengguna = $this->session->userdata('user_id');
        
        // Ambil data petani
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        
        // Pastikan petani ditemukan
        if (!$data['petani']) {
            show_error('Data petani tidak ditemukan', 404);
        }
        
        // Ambil ID petani
        $id_petani = $data['petani']['id_petani'];
        
        // Ambil data statistik khusus untuk petani ini
        $data['stats'] = $this->petani_model->get_stats($id_petani);
        
        // Ambil data permintaan terbaru
        $data['permintaan_terbaru'] = $this->petani_model->get_recent_permintaan();
        
        // Ambil aktivitas terbaru
        $data['aktivitas_terbaru'] = $this->petani_model->get_recent_activities();
        if($data['aktivitas_terbaru'] === null) {
            $data['aktivitas_terbaru'] = [];
        }
        
        // Load view dashboard
        $this->load->view('petani_index/index');
        $this->load->view('petani_index/header');
        $this->load->view('petani/dashboard', $data);
        $this->load->view('petani_index/footer');
    }
}