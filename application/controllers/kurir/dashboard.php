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
        
        if (!$data['kurir']) {
            // Handle jika data kurir tidak ditemukan
            show_error('Data kurir tidak ditemukan.', 404, 'Data Tidak Ditemukan');
        }
        
        
        // Ambil data penugasan
        $data['penugasan_aktif'] = $this->Kurir_model->get_active_assignments($id_kurir);
        $data['aktivitas'] = $this->db->get('aktivitas')->result_array();
        
        // Ambil statistik
        $stats = $this->Kurir_model->get_assignment_stats($id_kurir);
        $data['total_penugasan'] = $stats['total'];
        $data['dalam_proses'] = $stats['pick_up'];
        $data['selesai'] = $stats['approved'];
        $data['menunggu'] = $stats['pending'];
        
        $this->load->view('kurir_index/index');
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/dashboard', $data);
        $this->load->view('kurir_index/footer');
    }

    public function mulai_penugasan($id_penugasan) {
        if ($this->Kurir_model->update_assignment_status($id_penugasan, 'approved')) {
            $this->session->set_flashdata('success', 'Penugasan telah dimulai!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memulai penugasan.');
        }
        redirect('kurir');
    }
    public function mulai_pickup($id_penugasan) {
        if ($this->Penugasan_model->start_pickup($id_penugasan)) {
            $this->session->set_flashdata('success', 'Pengambilan barang telah dimulai!');
        } else {
            $this->session->set_flashdata('error', 'Gagal memulai pengambilan barang.');
        }
        redirect('kurir');
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

public function proses_verifikasi($id_penugasan) {
    $this->load->library('upload');
    
    // Konfigurasi upload
    $config['upload_path'] = './uploads/bukti_pengiriman/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048; // 2MB
    $config['encrypt_name'] = true;
    
    $this->upload->initialize($config);
    
    $foto_bukti = '';
    
    // Proses upload foto
    if ($this->upload->do_upload('foto_bukti')) {
        $upload_data = $this->upload->data();
        $foto_bukti = $upload_data['file_name'];
    } else {
        // Jika upload gagal, simpan pesan error
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect('kurir/verifikasi/'.$id_penugasan);
    }
    
    // Data untuk disimpan
    $data = [
        'foto_bukti' => $foto_bukti,
        'catatan' => $this->input->post('catatan')
    ];
    
    // Proses verifikasi
    if ($this->Kurir_model->complete_assignment($id_penugasan, $data)) {
        // Tambahkan aktivitas
        $this->load->model('Aktivitas_model');
        $this->Aktivitas_model->add_activity(
            $this->session->userdata('user_id'),
            'verifikasi',
            'Pengiriman ' . $data['tugas']->nama_komoditas . ' diverifikasi'
        );
        
        $this->session->set_flashdata('success', 'Pengiriman berhasil diverifikasi!');
    } else {
        $this->session->set_flashdata('error', 'Gagal memverifikasi pengiriman.');
    }
    
    redirect('kurir');
}
}