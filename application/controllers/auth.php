<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('pengguna_model');
        $this->load->model('distributor_model');
        $this->load->model('petani_model');
        $this->load->model('kurir_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function login() {
    // Set rules validasi
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('auth/login');
    } else {
        // Ambil data dari form
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        // Cek pengguna di database
        $user = $this->pengguna_model->getPenggunaByEmail($email);
        
        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user->kata_sandi)) {
                // AMBIL ID SPESIFIK BERDASARKAN PERAN
            $this->setUserSession($user);
             // Redirect berdasarkan peran
            $this->redirectToDashboard($user->peran);
                
            } else {
                $this->session->set_flashdata('error', 'Password salah');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Email tidak terdaftar');
            redirect('auth/login');
        }
    }
}

     public function register() {
        $data['distributors'] = $this->distributor_model->get_all();
        // Set rules validasi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[pengguna.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('peran', 'Peran', 'required');
        
        // Validasi khusus peran
        $peran = $this->input->post('peran');
        if ($peran == 'distributor') {
            $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
            $this->form_validation->set_rules('alamat_distributor', 'Alamat', 'required');
            $this->form_validation->set_rules('no_telepon_distributor', 'No. Telepon', 'required');
        } 
        elseif ($peran == 'petani') {
            $this->form_validation->set_rules('alamat_petani', 'Alamat', 'required');
            $this->form_validation->set_rules('no_telepon_petani', 'No. Telepon', 'required');
            $this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required|numeric');
        } 
        elseif ($peran == 'kurir') {
            $this->form_validation->set_rules('no_kendaraan', 'No. Kendaraan', 'required');
            $this->form_validation->set_rules('cakupan_area', 'Cakupan Area', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form kembali
            $this->load->view('auth/register', $data);
        } else {
            // Data untuk tabel pengguna
            $data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'kata_sandi' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'peran' => $this->input->post('peran')
            );
            
            // Simpan data pengguna
            $user_id = $this->pengguna_model->insertPengguna($data);
            
            if ($user_id) {
                // Data tambahan berdasarkan peran
                $role = $this->input->post('peran');
                
                if ($role == 'distributor') {
                    $distributor_data = array(
                        'id_pengguna' => $user_id,
                        'nama_perusahaan' => $this->input->post('nama_perusahaan'),
                        'alamat' => $this->input->post('alamat_distributor'),
                        'no_telepon' => $this->input->post('no_telepon_distributor')
                    );
                    $this->distributor_model->insert($distributor_data);
                } 
                elseif ($role == 'petani') {
                    $petani_data = array(
                        'id_pengguna' => $user_id,
                        'alamat' => $this->input->post('alamat_petani'),
                        'no_telepon' => $this->input->post('no_telepon_petani'),
                        'luas_lahan' => $this->input->post('luas_lahan')
                    );
                    $this->petani_model->insert($petani_data);
                } 
                elseif ($role == 'kurir') {
                    $kurir_data = array(
                        'id_pengguna' => $user_id,
                        'no_kendaraan' => $this->input->post('no_kendaraan'),
                        'cakupan_area' => $this->input->post('cakupan_area')
                    );
                    
                    // Jika distributor_id diperlukan, bisa ditambahkan di sini
                    $kurir_data['id_distributor'] = $this->input->post('id_distributor');
                    
                    $this->kurir_model->insert($kurir_data);
                }
                
                // Set pesan sukses
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    private function setUserSession($user) {
    // Inisialisasi variabel ID
        $id_distributor = null;
        $id_petani = null;
        $id_kurir = null;
        $nama_perusahaan = null;
        $alamat = null;

        // Ambil ID spesifik berdasarkan peran
        switch ($user->peran) {
            case 'distributor':
                $distributor = $this->distributor_model->getByUserId($user->id_pengguna);
                if ($distributor) {
                    $id_distributor = $distributor->id_distributor;
                    $nama_perusahaan = $distributor->nama_perusahaan; 
                }
                break;
            case 'petani':
                $petani = $this->petani_model->getByUserId($user->id_pengguna);
                if ($petani) {
                    $id_petani = $petani->id_petani;
                    $alamat = $petani->alamat; 
                }
                break;
            case 'kurir':
                $kurir = $this->kurir_model->getByUserId($user->id_pengguna);
                $id_kurir = $kurir ? $kurir->id_kurir : null;
                break;
        }

        $sessionData = array(
            'user_id' => $user->id_pengguna,
            'nama' => $user->nama,
            'email' => $user->email,
            'peran' => $user->peran,
            'logged_in' => true,
            'id_distributor' => $id_distributor,
            'nama_distributor' => $nama_perusahaan, 
            'id_petani' => $id_petani,
            'id_kurir' => $id_kurir
        );

        $this->session->set_userdata($sessionData);
    }

    private function redirectToDashboard($peran) {
        switch ($peran) {
            case 'admin':
                redirect('admin/dashboard');
                break;
            case 'distributor':
                redirect('distributor/dashboard');
                break;
            case 'petani':
                redirect('petani/dashboard');
                break;
            case 'kurir':
                redirect('kurir/dashboard');
                break;
            default:
                redirect('auth/login');
                break;
        }
    }

    // Di controller Auth
// 
}