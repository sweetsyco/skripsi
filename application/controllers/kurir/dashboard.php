<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kurir_model');
        $this->load->helper('waktu_helper');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        } elseif ($this->session->userdata('peran') != 'kurir') {
            redirect('auth/login');
        }
    }

    public function index() {
        $id_pengguna = $this->session->userdata('user_id');
        $id_kurir = $this->session->userdata('id_kurir');
        $data['kurir'] = $this->Kurir_model->get_kurir_by_user_id($id_pengguna);
        $data['title'] = "Dashboard Kurir - AgriConnect";
        
        if (!$data['kurir']) {
            // Handle jika data kurir tidak ditemukan
            show_error('Data kurir tidak ditemukan.', 404, 'Data Tidak Ditemukan');
        }
        
        
       
        $data['penugasan_aktif'] = $this->Kurir_model->get_active_assignments($id_kurir);
        $data['aktivitas'] = $this->Kurir_model->get_recent_activities($id_pengguna);
        
        
        $stats = $this->Kurir_model->get_assignment_stats($id_kurir);
        $data['total_penugasan'] = $stats['total'];
        $data['dalam_proses'] = $stats['pick up'];
        $data['selesai'] = $stats['approved'];
        $data['menunggu'] = $stats['pending'];
        
        $this->load->view('kurir_index/index',$data);
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/dashboard', $data);
        $this->load->view('kurir_index/footer');
    }


    public function verifikasi_penugasan($id_penugasan) {
        if ($this->Kurir_model->update_assignment_status($id_penugasan, 'completed')) {
            $this->session->set_flashdata('success', 'Penugasan berhasil diverifikasi!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memverifikasi penugasan.');
        }
        redirect('kurir');
    }

    public function verifikasi($id_penugasan) {
    $id_pengguna = $this->session->userdata('user_id');
    $data['kurir'] = $this->Kurir_model->get_kurir_by_user_id($id_pengguna);
    
    if (!$data['kurir']) {
        show_error('Data kurir tidak ditemukan.', 404, 'Data Tidak Ditemukan');
    }
    
    $data['tugas'] = $this->Kurir_model->get_assignment_details($id_penugasan);
    
    if (!$data['tugas']) {
        show_error('Data penugasan tidak ditemukan.', 404, 'Data Tidak Ditemukan');
    }
    
    $this->load->view('kurir_index/index');
    $this->load->view('kurir_index/header');
    $this->load->view('kurir/verifikasi/index', $data);
    $this->load->view('kurir_index/footer');
}

}