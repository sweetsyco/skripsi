<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Petani_model');
        $this->load->model('Penawaran_model');
        $this->load->library('form_validation');
        
        // Pastikan hanya petani yang bisa akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'petani') {
            redirect('login');
        }
    }

    public function index() {
         $id_pengguna = $this->session->userdata('user_id');
        $data['petani'] = $this->Petani_model->get_by_pengguna($id_pengguna);
        
        // Ambil statistik penawaran dan transaksi
        if ($data['petani']) {
            $id_petani = $data['petani']['id_petani'];
            $data['penawaran_dikirim'] = $this->Penawaran_model->count_penawaran_dikirim($id_petani);
            $data['penawaran_diterima'] = $this->Penawaran_model->count_penawaran_diterima($id_petani);
            $data['total_transaksi'] = $this->Penawaran_model->total_transaksi($id_petani);
        } else {
            $data['penawaran_dikirim'] = 0;
            $data['penawaran_diterima'] = 0;
            $data['total_transaksi'] = 0;
        }
        $this->load->view('petani_index/index_profile');
        $this->load->view('petani_index/header');
        $this->load->view('petani/profile/index', $data);
        $this->load->view('petani_index/profile_footer');
    }

    public function edit_profil() {
        $id_pengguna = $this->session->userdata('user_id');
        $petani = $this->Petani_model->get_by_pengguna($id_pengguna);
        
        if (!$petani) {
            $this->session->set_flashdata('error', 'Data profil tidak ditemukan');
            redirect('petani/profil');
        }

        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'required');
        $this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['petani'] = $petani;
            $this->load->view('templates/header');
            $this->load->view('petani/edit_profil', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = [
                'alamat' => $this->input->post('alamat'),
                'no_telepon' => $this->input->post('no_telepon'),
                'luas_lahan' => $this->input->post('luas_lahan')
            ];
            
            // Update password jika diisi
            $password = $this->input->post('password');
            if (!empty($password)) {
                $update_data['kata_sandi'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->Petani_model->update($petani['id_petani'], $update_data)) {
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui profil');
            }

            redirect('petani/profil');
        }
    }
}