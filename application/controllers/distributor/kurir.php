<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kurir_model');
        $this->load->model('distributor_model');
        // Cek login dan peran
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'distributor') {
            redirect('auth/login');
        }
    }

    public function create() {
        $id_distributor = $this->session->userdata('id_distributor');
        $data['kurir'] = $this->kurir_model->get_kurir_by_distributor($id_distributor);
        $data['title'] = "Manajemen Kurir";
        
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/kurir/list', $data);
        $this->load->view('distributor_index/kurir_footer');
    }

    public function penugasan() {
        $id_kurir = $this->session->userdata('id_kurir');
        $data['penugasan'] = $this->kurir_model->get_penugasan($id_kurir);
        
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('kurir/penugasan', $data);
        $this->load->view('distributor_index/kurir_footer');
    }


    public function update_status() {
        $id_penugasan = $this->input->post('id_penugasan');
        $status = $this->input->post('status');
        $catatan = $this->input->post('catatan');
        
        $this->kurir_model->update_status_penugasan($id_penugasan, $status, $catatan);
        
        redirect('kurir/detail_penugasan/'.$id_penugasan);
    }
    
    public function edit_kurir($id_kurir) {
    $id_distributor = $this->session->userdata('id_distributor');
    $data['kurir'] = $this->Distributor_model->get_detail_kurir($id_kurir, $id_distributor);
    
    if (!$data['kurir']) {
        show_404();
    }
    
    $this->load->view('distributor_index/index',$data);
    $this->load->view('distributor_index/header');
    $this->load->view('distributor/edit_kurir', $data);
    $this->load->view('distributor_index/kurir_footer');
}

public function proses_tambah_kurir() {
        $id_distributor = $this->session->userdata('id_distributor');
        
        // Validasi form
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('no_kendaraan', 'No Kendaraan', 'required');
        $this->form_validation->set_rules('cakupan_area', 'Cakupan Area', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->tambah_kurir();
        } else {
            // Data untuk tabel pengguna
            $data_pengguna = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'kata_sandi' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'peran' => 'kurir'
            ];
            
            // Simpan data pengguna
            $this->db->insert('pengguna', $data_pengguna);
            $id_pengguna = $this->db->insert_id();
            
            // Data untuk tabel kurir
            $data_kurir = [
                'id_pengguna' => $id_pengguna,
                'id_distributor' => $id_distributor,
                'no_telepon' => $this->input->post('no_telp'),
                'alamat' => $this->input->post('alamat'),
                'no_kendaraan' => $this->input->post('no_kendaraan'),
                'cakupan_area' => $this->input->post('cakupan_area')
            ];
            
            // Simpan data kurir
            $this->db->insert('kurir', $data_kurir);
            
            $this->session->set_flashdata('success', 'Kurir berhasil ditambahkan');
            redirect('distributor/kurir/tambah');
        }
    }

    public function proses_update_kurir() {
    $id_kurir = $this->input->post('id_kurir');
    $id_distributor = $this->session->userdata('id_distributor');
    
    
    // Dapatkan detail kurir
    $kurir = $this->kurir_model->get_detail_kurir($id_kurir, $id_distributor);
    
    if (!$kurir) {
        $this->session->set_flashdata('error', 'Data kurir tidak ditemukan');
        redirect('Distributor/kurir/create');
    }
    
    // Validasi form
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('no_kendaraan', 'No Kendaraan', 'required');
    $this->form_validation->set_rules('cakupan_area', 'Cakupan Area', 'required');
    
    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, tampilkan halaman edit lagi
        $data['kurir'] = $kurir;
        $data['error'] = validation_errors();
        
    
        $this->load->view('distributor/kurir/create', $data);
        
    } else {
        // Data untuk tabel pengguna
        $data_pengguna = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email')
        ];
        
        // Jika password diisi, update password
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data_pengguna['kata_sandi'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        // Update data pengguna
        $this->db->where('id_pengguna', $kurir->id_pengguna);
        $this->db->update('pengguna', $data_pengguna);
        
        // Data untuk tabel kurir
        $data_kurir = [
            'no_telepon' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat'),
            'no_kendaraan' => $this->input->post('no_kendaraan'),
            'cakupan_area' => $this->input->post('cakupan_area')
        ];
        
        // Update data kurir
        $this->db->where('id_kurir', $id_kurir);
        $this->db->update('kurir', $data_kurir);
        
        $this->session->set_flashdata('success', 'Data kurir berhasil diperbarui');
        redirect('Distributor/kurir/create');
    }
}
    public function delete_kurir($id_kurir) {
        $id_distributor = $this->session->userdata('id_distributor');
        
        // Pastikan kurir tersebut milik distributor yang login
        $kurir = $this->kurir_model->get_detail_kurir($id_kurir, $id_distributor);
        
        if (!$kurir) {
            $this->session->set_flashdata('error', 'Data kurir tidak ditemukan');
            redirect('distributor/kurir/create');
        }
        
        // Hapus kurir
        if ($this->kurir_model->delete_kurir($id_kurir)) {
            $this->session->set_flashdata('success', 'Kurir berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kurir');
        }
        
        redirect('distributor/kurir/create');
    }
}


    
   

