<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kurir_model');
        $this->load->library('form_validation');
        
        // Pastikan hanya kurir yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'kurir') {
            redirect('login');
        }
    }

    public function index() {
        $id_pengguna = $this->session->userdata('user_id');
        $data['kurir'] = $this->Kurir_model->get_by_pengguna($id_pengguna);
        $data['title'] = "Profile Kurir - AgriConnect";
        
        if (!$data['kurir']) {
            $this->session->set_flashdata('error', 'Data profil tidak ditemukan');
            redirect('kurir/dashboard');
        }

        // Hitung statistik penugasan
        $id_kurir = $data['kurir']['id_kurir'];
        $data['penugasan_aktif'] = $this->Kurir_model->count_penugasan_aktif($id_kurir);
        $data['total_penugasan'] = $this->Kurir_model->count_total_penugasan($id_kurir); 

        
        $this->load->view('kurir_index/index',$data);
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/profile/index', $data);
        $this->load->view('kurir_index/footer');
    }

    public function edit_profil() {
        $id_pengguna = $this->session->userdata('user_id');
        $kurir = $this->Kurir_model->get_by_pengguna($id_pengguna);
        
        if (!$kurir) {
            $this->session->set_flashdata('error', 'Data profil tidak ditemukan');
            redirect('kurir/profile');
        }

        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_kendaraan', 'Nomor Kendaraan', 'required');
        $this->form_validation->set_rules('cakupan_area', 'Cakupan Area', 'required');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['kurir'] = $kurir;
            $this->load->view('kurir_index/index',$data);
            $this->load->view('kurir_index/header');
            $this->load->view('kurir/profile/index', $data);
            $this->load->view('kurir_index/footer');
        } else {
            $update_data = [
                'no_telepon' => $this->input->post('no_telepon'),
                'alamat' => $this->input->post('alamat'),
                'no_kendaraan' => $this->input->post('no_kendaraan'),
                'cakupan_area' => $this->input->post('cakupan_area')
            ];
            
            // Update password jika diisi
            $password = $this->input->post('password');
            if (!empty($password)) {
                $update_data['kata_sandi'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Update data kurir
            if ($this->Kurir_model->update($kurir['id_kurir'], $update_data)) {
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil');
            }

            redirect('kurir/profile');
        }
    }
}