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

    public function get_detail($id_penugasan) {
    $id_pengguna = $this->session->userdata('user_id');
    $petani = $this->petani_model->get_petani_data($id_pengguna);
    
    if(empty($petani)) {
        $response = array('status' => 'error', 'message' => 'Profil petani tidak ditemukan');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
    }
    
    $id_petani = $petani['id_petani'];
    $penugasan = $this->penugasan_model->get_penugasan_detail_petani($id_penugasan, $id_petani);
    
    if(empty($penugasan)) {
        $response = array('status' => 'error', 'message' => 'Data penugasan tidak ditemukan');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
    }
    
    // Format data untuk response
    $data = array(
        'status' => 'success',
        'data' => $penugasan
    );
    
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}