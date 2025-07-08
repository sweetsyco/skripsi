<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penugasan_model');
        $this->load->model('kurir_model');
        if ($this->session->userdata('peran') != 'distributor') {
            redirect('login');
        }
    }

    public function index() {
        $id_distributor = $this->session->userdata('id_distributor');
    $data['title'] = "Manajemen Kurir";
    
    $data['penugasan'] = $this->penugasan_model->get_penugasan_by_distributor($id_distributor);
    
    $data['penawaran'] = $this->penugasan_model->get_accepted_penawaran($id_distributor);
    
    $data['kurir'] = $this->penugasan_model->get_kurir_by_distributor($id_distributor);
   
    
    if (empty($data['penawaran'])) {
        $this->session->set_flashdata('info', 'Tidak ada penawaran yang tersedia untuk ditugaskan. Semua penawaran sudah ditugaskan.');
    }
    
    $this->load->view('distributor_index/index',$data);
    $this->load->view('distributor_index/header');
    $this->load->view('distributor/kurir/penugasan', $data);
    $this->load->view('distributor_index/footer');
    }
    

    public function create() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_penawaran', 'Penawaran', 'required');
    $this->form_validation->set_rules('id_kurir', 'Kurir', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('penugasan');
    }

    $data = array(
        'id_penawaran' => $this->input->post('id_penawaran'),
        'id_kurir' => $this->input->post('id_kurir'),
        'status' => 'pick up',
        'ditugaskan_pada' => date('Y-m-d H:i:s')
    );

    // Dapatkan data untuk aktivitas
    $id_penawaran = $this->input->post('id_penawaran');
    $id_kurir = $this->input->post('id_kurir');
    
    $penawaran = $this->penugasan_model->get_penawaran_detail($id_penawaran);
    $kurir = $this->penugasan_model->get_kurir_detail($id_kurir);
    
   
    if ($id_penugasan = $this->penugasan_model->create_penugasan($data)) {
        
        $aktivitas_distributor = [
            'id_pengguna' => $this->session->userdata('user_id'),
            'id_distributor' => $this->session->userdata('id_distributor'),
            'jenis' => 'penugasan',
            'pesan' => "Penugasan baru #$id_penugasan untuk {$penawaran['nama_komoditas']} ({$penawaran['jumlah']} kg) ke {$kurir['nama']}",
            'waktu' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('aktivitas', $aktivitas_distributor);
        
        // Aktivitas untuk kurir
        $aktivitas_kurir = [
            'id_pengguna' => $kurir['id_pengguna'],
            'id_distributor' => $this->session->userdata('id_distributor'),
            'jenis' => 'penugasan',
            'pesan' => "Anda mendapat penugasan baru #$id_penugasan: {$penawaran['nama_komoditas']} ({$penawaran['jumlah']} kg)",
            'waktu' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('aktivitas', $aktivitas_kurir);
        
        $this->session->set_flashdata('success', 'Penugasan berhasil dibuat!');
    } else {
        $this->session->set_flashdata('error', 'Gagal membuat penugasan');
    }
    redirect('distributor/penugasan');
}

 
    public function detail($id_penugasan) {
    $this->load->helper('file');
    $id_distributor = $this->session->userdata('id_distributor');
    
    $data['penugasan'] = $this->penugasan_model->get_penugasan_detail($id_penugasan);
    $data['bukti'] = $this->kurir_model->get_penugasan_detail($id_penugasan);
    $data['title'] = "Manajemen Kurir";
    
    
    if (!$data['penugasan'] || $data['penugasan']['id_distributor'] != $id_distributor) {
        show_404();
    }
    if (!empty($data['penugasan']['foto_bukti'])) {
        $data['penugasan']['foto_bukti_url'] = base_url('uploads/bukti/' . $data['penugasan']['foto_bukti']);
    }
    
    $data['distributor'] = [
        'nama_perusahaan' => $this->session->userdata('nama_perusahaan'),
        'alamat' => $this->session->userdata('alamat_distributor'),
        'no_telepon' => $this->session->userdata('no_telepon')
    ];
    $this->load->view('distributor_index/index',$data);
    $this->load->view('distributor_index/header');
    $this->load->view('distributor/kurir/detail_penugasan', $data);
    $this->load->view('distributor_index/footer');
}
public function update_status($id_penugasan, $status) {
    // Pastikan hanya distributor yang bisa akses
    if ($this->session->userdata('peran') != 'distributor') {
        redirect('login');
    }
    
    $id_distributor = $this->session->userdata('id_distributor');
    $id_pengguna = $this->session->userdata('id_pengguna');
    
    $allowed_status = ['approved','pick up', 'rejected'];
    if (!in_array($status, $allowed_status)) {
        $this->session->set_flashdata('error', 'Status tidak valid');
        redirect('distributor/penugasan');
    }
    
    $penugasan = $this->penugasan_model->get_penugasan_detail($id_penugasan);
    
    if (!$penugasan || $penugasan['id_distributor'] != $id_distributor) {
        $this->session->set_flashdata('error', 'Penugasan tidak ditemukan atau tidak memiliki akses');
        redirect('distributor/penugasan');
    }
    
    
    if ($penugasan['status'] != 'pending') {
        $this->session->set_flashdata('error', 'Status penugasan sudah diproses sebelumnya');
        redirect('distributor/penugasan');
    }
    
    
    if ($this->penugasan_model->update_status($id_penugasan, $status)) {
        
        $pesan = "Penugasan #{$id_penugasan} untuk ";
        $pesan .= "{$penugasan['nama_komoditas']} ({$penugasan['jumlah']} kg) ";
        $pesan .= "telah diubah menjadi " . ($status == 'approved' ? 'Disetujui' : 'Ditolak');
        
        
        $aktivitas_distributor = [
            'id_pengguna' => $id_pengguna,
            'id_distributor' => $id_distributor,
            'jenis' => 'penugasan',
            'pesan' => $pesan,
            'waktu' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('aktivitas', $aktivitas_distributor);
        
        
        $aktivitas_kurir = [
            'id_pengguna' => $penugasan['id_pengguna_kurir'],
            'id_distributor' => $id_distributor,
            'jenis' => 'penugasan',
            'pesan' => $pesan,
            'waktu' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('aktivitas', $aktivitas_kurir);
        
        $this->session->set_flashdata('success', 'Status penugasan berhasil diupdate!');
    } else {
        $this->session->set_flashdata('error', 'Gagal mengupdate status');
    }
    
    redirect('distributor/penugasan');
}

public function view_bukti($id_penugasan) {
    $id_distributor = $this->session->userdata('id_distributor');
    $penugasan = $this->kurir_model->get_penugasan_detail($id_penugasan);
    
    if (!$penugasan || $penugasan['id_distributor'] != $id_distributor) {
        show_404();
    }
    
    if (empty($penugasan['foto_bukti'])) {
        $this->session->set_flashdata('error', 'Bukti foto tidak tersedia');
        redirect('distributor/penugasan');
    }

   
    redirect($penugasan['foto_bukti_url']);
}

public function approve($id_penugasan) {
    $this->_validate_access($id_penugasan);
    
   
    $catatan = $this->input->post('catatan');
    
    if ($this->penugasan_model->update_status($id_penugasan, 'approved', $catatan)) {
        $this->_log_activity($id_penugasan, 'approved', 'Penugasan disetujui');
        $this->session->set_flashdata('success', 'Penugasan berhasil disetujui!');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyetujui penugasan');
    }
    
    redirect('distributor/penugasan/detail/' . $id_penugasan);
}

public function reject($id_penugasan) {
    $this->_validate_access($id_penugasan);
    
    $catatan = $this->input->post('catatan');
    if (empty($catatan)) {
        $this->session->set_flashdata('error', 'Catatan penolakan wajib diisi');
        redirect('distributor/penugasan/detail/' . $id_penugasan);
    }
    
    if ($this->penugasan_model->update_status($id_penugasan, 'rejected', $catatan)) {
        $this->_log_activity($id_penugasan, 'rejected', 'Penugasan ditolak: ' . $catatan);
        $this->session->set_flashdata('success', 'Penugasan berhasil ditolak!');
    } else {
        $this->session->set_flashdata('error', 'Gagal menolak penugasan');
    }
    
    redirect('distributor/penugasan/detail/' . $id_penugasan);
}

private function _validate_access($id_penugasan) {
    if ($this->session->userdata('peran') != 'distributor') {
        redirect('login');
    }
    
    $penugasan = $this->penugasan_model->get_penugasan_detail($id_penugasan);
    $distributor_id = $this->session->userdata('id_distributor');
    
    if (!$penugasan || $penugasan['id_distributor'] != $distributor_id) {
        show_404();
    }
}

private function _log_activity($id_penugasan, $status, $message) {
    $penugasan = $this->penugasan_model->get_penugasan_detail($id_penugasan);
    
    $aktivitas_distributor = [
        'id_pengguna' => $this->session->userdata('user_id'),
        'id_distributor' => $this->session->userdata('id_distributor'),
        'jenis' => 'verifikasi',
        'pesan' => "Penugasan #$id_penugasan ({$penugasan['nama_komoditas']}) $message",
        'waktu' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('aktivitas', $aktivitas_distributor);
    
    
    $aktivitas_kurir = [
        'id_pengguna' => $this->session->userdata('user_id'),
        'id_distributor' => $this->session->userdata('id_distributor'),
        'jenis' => 'verifikasi',
        'pesan' => "Penugasan #$id_penugasan ({$penugasan['nama_komoditas']}) $message",
        'waktu' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('aktivitas', $aktivitas_kurir);
}

}