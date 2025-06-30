<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Petani_model');
        $this->load->library('form_validation');
        
        // Pastikan hanya petani yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'petani') {
            redirect('login');
        }
    }

    public function index() {
        $id_pengguna = $this->session->userdata('user_id');
        $data['petani'] = $this->Petani_model->get_by_pengguna($id_pengguna);
        
        $this->load->view('petani_index/index');
        $this->load->view('petani_index/header');
        $this->load->view('petani/profile/index', $data);
        $this->load->view('petani_index/footer');
    }

    public function update() {
        $id_pengguna = $this->session->userdata('id_pengguna');
        $data['petani'] = $this->Petani_model->get_by_pengguna($id_pengguna);
        
        // Set rules validasi
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            // Tampilkan form dengan error
            $this->load->view('petani_index/index');
            $this->load->view('petani_index/header');
            $this->load->view('petani/profile/index', $data);
            $this->load->view('petani_index/footer');
        } else {
            // Data untuk update
            $update_data = array(
                'alamat' => $this->input->post('alamat'),
                'no_telepon' => $this->input->post('no_telepon'),
                'luas_lahan' => $this->input->post('luas_lahan')
            );
            
            if ($this->Petani_model->update($data['petani']['id_petani'], $update_data)) {
                $this->session->set_flashdata('sukses', 'Profil berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil!');
            }
            
            redirect('profile');
        }
    }
}