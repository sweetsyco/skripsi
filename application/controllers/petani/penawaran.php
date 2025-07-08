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
        $id_petani = $this->session->userdata('id_petani');

        $data['penawaran'] = $this->penawaran_model->get_penawaran_by_petani($id_petani);
        $status_counts = $this->penawaran_model->get_status_counts($id_petani);
        $data['count_pending'] = $status_counts['pending'];
        $data['count_diterima'] = $status_counts['accepted'];
        $data['count_ditolak'] = $status_counts['rejected'];
        $data['total_penawaran'] = $status_counts['total'];
        $data['title'] = "List Penawaran - AgriConnect";
        
        $this->load->view('petani_index/index',$data);
        $this->load->view('petani_index/header');
        $this->load->view('petani/penawaran/index', $data);
        $this->load->view('petani_index/penawaran_footer');
    }

    // Form buat penawaran baru
    public function create($id_permintaan = null) {
            $id_pengguna = $this->session->userdata('user_id');
            $data['petani'] = $this->petani_model->get_petani_data($id_pengguna);
            $data['title'] = "Buat Penawaran - AgriConnect";
            
            if(empty($data['petani'])) {
                show_error('Profil petani tidak ditemukan. Silakan lengkapi profil Anda.', 404);
            }
            
            $id_petani = $data['petani']['id_petani'];

            
            $this->load->model('permintaan_model');
            
            
            if(empty($id_permintaan)) {
                $data['permintaan'] = $this->permintaan_model->get_active_permintaan();
                $data['title'] = "List Permintaan - AgriConnect";
                $this->load->view('petani_index/index', $data);
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
                
                $this->load->view('petani_index/index',$data);
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

                if($id_penawaran = $this->penawaran_model->create_penawaran($data_penawaran)){
                    $permintaan = $this->permintaan_model->get_permintaan_by_id($id_permintaan);
                    $penawaran = $this->penawaran_model->get_penawaran_by_id($id_penawaran, $id_petani);
                    $aktivitas_distributor = [
                    'id_pengguna' => $this->session->userdata('user_id'),
                    'id_distributor' => $this->session->userdata('id_distributor'),
                    'jenis' => 'Penawaran',
                    'pesan' => "Penawaran baru untuk Permintaan {$permintaan['nama_komoditas']} Sebanyak {$penawaran['jumlah']} kg",
                    'waktu' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('aktivitas', $aktivitas_distributor);
                    $this->session->set_flashdata('success', 'Penugasan berhasil dibuat!');
                }else{
                    $this->session->set_flashdata('error', 'Gagal membuat penugasan');
                }
               
                redirect('petani/penawaran');
                
            }
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
        
        $response = [
            'success' => true,
            'data' => [
                'komoditas' => $penawaran['nama_komoditas'],
                'distributor' => $penawaran['nama_perusahaan'],
                'jumlah' => number_format($penawaran['jumlah']) . ' kg',
                'harga' => 'Rp ' . number_format($penawaran['harga'], 0, ',', '.'),
                'status' => $penawaran['status'],
                'tanggal' => date('d M Y', strtotime($penawaran['dibuat_pada']))
            ]
        ];
        
        echo json_encode($response);
    }

    // Edit penawaran
    public function update() {
        $id_pengguna = $this->session->userdata('user_id');
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
        
        redirect('petani/penawaran');
    }


    // Hapus penawaran
    public function delete($id_penawaran) {
        $id_pengguna = $this->session->userdata('user_id');
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
        redirect('petani/penawaran');
    }
    
    public function buat_surat_perjanjian($id_penawaran) {
    // Load model dan library
    $this->load->helper('pdf_helper');
    
    $penawaran = $this->penawaran_model->getByIdWithDetails($id_penawaran);
    
    $id_petani = $this->session->userdata('id_petani');
    
    if(!$penawaran || $penawaran['id_petani'] != $id_petani || $penawaran['status'] != 'accepted') {
        show_error('Penawaran tidak valid atau belum diterima', 400);
    }
    

    // Data untuk kontrak
    $data = [
        'no_kontrak' => 'K-' . date('Ymd') . '-' . str_pad($id_penawaran, 5, '0', STR_PAD_LEFT),
        'nama_petani' => $this->session->userdata('nama'),
        'alamat_petani' => $penawaran['alamat_petani'],
        'nama_distributor' => $penawaran['nama_perusahaan'],
        'alamat_distributor' => $penawaran['alamat_distributor'],
        'komoditas' => $penawaran['nama_komoditas'],
        'jumlah' => $penawaran['jumlah'],
        'harga' => $penawaran['harga'],
        'total' => $penawaran['jumlah'] * $penawaran['harga'],
        'tanggal_mulai' => date('Y-m-d'),
        'tanggal_berakhir' => date('Y-m-d', strtotime('+1 year')),
        'tanggal_surat' => date('d F Y')
    ];

    // Generate nama file
    $filename = 'surat_perjanjian_'.$data['no_kontrak'].'.pdf';
    
    // Generate PDF menggunakan DomPDF
    generate_surat_perjanjian_pdf($data, $filename);
}
}