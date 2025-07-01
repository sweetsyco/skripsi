<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penawaran extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penawaran_model');
        $this->load->model('petani_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'petani') {
            redirect('auth/login');
        }
    }

    // Daftar penawaran
    public function index() {
        $id_pengguna = $this->session->userdata('user_id');
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        if(empty($data['petani'])) {
            show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
        }
        $id_petani = $data['petani']['id_petani'];

            $data['penawaran'] = $this->penawaran_model->get_penawaran_by_petani($id_petani);
            $status_counts = $this->penawaran_model->get_status_counts($id_petani);
            $data['count_pending'] = $status_counts['pending'];
            $data['count_diterima'] = $status_counts['accepted'];
            $data['count_ditolak'] = $status_counts['rejected'];
            $data['total_penawaran'] = $status_counts['total'];
        
        $this->load->view('petani_index/index');
        $this->load->view('petani_index/header');
        $this->load->view('petani/penawaran/index', $data);
        $this->load->view('petani_index/footer');
    }

    // Form buat penawaran baru
    public function create($id_permintaan = null) {
            $id_pengguna = $this->session->userdata('user_id');
            $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
            
            if(empty($data['petani'])) {
                show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
            }
            
            $id_petani = $data['petani']['id_petani'];

            // Load model permintaan
            $this->load->model('permintaan_model');
            
            // Jika tidak ada id_permintaan, tampilkan halaman pemilihan permintaan
            if(empty($id_permintaan)) {
                $data['permintaan'] = $this->permintaan_model->get_active_permintaan();
                $this->load->view('petani_index/index');
                $this->load->view('petani_index/header');
                $this->load->view('petani/penawaran/select_permintaan', $data);
                $this->load->view('petani_index/footer');
                return;
            }

            $data['permintaan'] = $this->permintaan_model->get_permintaan_by_id($id_permintaan);

            if(empty($data['permintaan'])) {
                show_404();
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

            if ($this->form_validation->run() === FALSE) {
                // Tampilkan form create
                
                $this->load->view('petani_index/index');
                $this->load->view('petani_index/header');
                $this->load->view('petani/penawaran/create', $data);
                $this->load->view('petani_index/penawaran_footer');
            } else {
                
                $data_penawaran = [
                    'id_permintaan' => $id_permintaan,
                    'id_petani' => $id_petani,
                    'jumlah' => $this->input->post('jumlah'),
                    'harga' => $this->input->post('harga'),
                    'status' => 'pending',
                    'dibuat_pada' => date('Y-m-d H:i:s')
                ];

                $id_penawaran = $this->penawaran_model->create_penawaran($data_penawaran);
               
                redirect('petani/penawaran');
                
            }
        }

    // Detail penawaran
    public function view($id_penawaran) {
        $id_pengguna = $this->session->userdata('id_pengguna');
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        if(empty($data['petani'])) {
            show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
        }
        $id_petani = $data['petani']['id_petani'];

        $data['penawaran'] = $this->penawaran_model->get_penawaran_by_id($id_penawaran, $id_petani);
        if(empty($data['penawaran'])) {
            show_404();
        }

        $this->load->view('penawaran/view', $data);
    }

    // Edit penawaran
    public function update() {
        $id_pengguna = $this->session->userdata('id_pengguna');
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        
        if(empty($data['petani'])) {
            show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
        }
        
        $id_petani = $data['petani']['id_petani'];
        $id_penawaran = $this->input->post('id_penawaran');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('penawaran');
        }

        $update_data = [
            'jumlah' => $this->input->post('jumlah'),
            'harga' => $this->input->post('harga'),
            'diubah_pada' => date('Y-m-d H:i:s')
        ];

        $updated = $this->penawaran_model->update_penawaran($id_penawaran, $id_petani, $update_data);
        
        if ($updated) {
            $this->session->set_flashdata('success', 'Penawaran berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui penawaran.');
        }
        
        redirect('penawaran');
    }


    // Hapus penawaran
    public function delete($id_penawaran) {
        $id_pengguna = $this->session->userdata('id_pengguna');
        $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
        if(empty($data['petani'])) {
            show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
        }
        $id_petani = $data['petani']['id_petani'];

        $penawaran = $this->penawaran_model->get_penawaran_by_id($id_penawaran, $id_petani);
        if(empty($penawaran)) {
            show_404();
        }

        $deleted = $this->penawaran_model->delete_penawaran($id_penawaran, $id_petani);
        if ($deleted) {
            $this->session->set_flashdata('success', 'Penawaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penawaran.');
        }
        redirect('penawaran');
    }
    public function get_detail_json($id_penawaran) {
    $id_pengguna = $this->session->userdata('user_id');
    $petani = $this->petani_model->get_petani_data($id_pengguna);
    
    if(empty($petani)) {
        echo json_encode(['error' => 'Profil petani tidak ditemukan']);
        return;
    }
    
    $id_petani = $petani['id_petani'];
    $penawaran = $this->penawaran_model->get_penawaran_by_id($id_penawaran, $id_petani);
    
    if(empty($penawaran)) {
        echo json_encode(['error' => 'Penawaran tidak ditemukan']);
        return;
    }
    
    // Format data untuk response JSON
    $response = [
        'success' => true,
        'data' => [
            'komoditas' => $penawaran['nama_komoditas'],
            'distributor' => $penawaran['nama_perusahaan'],
            'jumlah' => number_format($penawaran['jumlah']) . ' kg',
            'harga' => 'Rp ' . number_format($penawaran['harga'], 0, ',', '.'),
            'status' => $penawaran['status'],
            'tanggal_dibuat' => date('d M Y', strtotime($penawaran['dibuat_pada'])),
            'tanggal_diubah' => $penawaran['diubah_pada'] ? date('d M Y', strtotime($penawaran['diubah_pada'])) : '-',
            'catatan' => $penawaran['catatan'] ?? 'Tidak ada catatan tambahan'
        ]
    ];
    
    echo json_encode($response);
}
}