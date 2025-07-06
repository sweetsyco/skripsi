<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Cek login dan peran
        if (!$this->session->userdata('logged_in') || $this->session->userdata('peran') !== 'distributor') {
            redirect('auth/login');
        }
        
        $this->load->model('Permintaan_model');
        $this->load->model('penawaran_model');
        $this->load->model('Komoditas_model');
        $this->load->model('Aktivitas_model');
        $this->load->library('form_validation');
        $this->load->helper('waktu_helper.php');
    }

    public function index() {
        $id_distributor = $this->session->userdata('id_distributor');
        $this->load->helper('waktu_helper');
        $this->load->helper('color_helper');

        $this->load->library('pagination');
        $config['base_url'] = base_url('distributor/permintaan/index');
        $config['total_rows'] = $this->Permintaan_model->count_by_distributor($id_distributor);
        $config['per_page'] = 10; // Jumlah item per halaman
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = '<ul class="pagination mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        // Ambil halaman saat ini dari segmen URI
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        // Load model dengan pagination
        $permintaan = $this->Permintaan_model->get_with_komoditas_paginated(
            $id_distributor, 
            $config['per_page'], 
            $page
        );
        // Load model
        //$permintaan = $this->Permintaan_model->get_with_komoditas($id_distributor);
        
        // Hitung statistik
        foreach ($permintaan as $p) {
        $p->progres = ($p->jumlah > 0) 
            ? (($p->jumlah - $p->sisa_permintaan) / $p->jumlah) * 100 
            : 0;
        }

        $total_permintaan = count($permintaan);
        $permintaan_selesai = 0;
        
        foreach ($permintaan as $p) {
            if ($p->status == 'closed') {
                $permintaan_selesai++;
            }
        }
        
        $total_permintaan = $this->Permintaan_model->count_by_distributor($id_distributor);
        $permintaan_selesai = $this->Permintaan_model->count_closed_by_distributor($id_distributor);
        // Dapatkan statistik komoditas dari model
        $komoditas_stats = $this->Permintaan_model->get_komoditas_stats($id_distributor);
        
        $data = [
            'title' => 'Manajemen Permintaan',
            'permintaan' => $permintaan,
            'total_permintaan' => $total_permintaan,
            'permintaan_selesai' => $permintaan_selesai,
            'komoditas_stats' => $komoditas_stats,
            'komoditas' => $this->Komoditas_model->get_all(),
            'pagination_links' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'per_page' => $config['per_page'],
            'current_page' => $page,
            'total_permintaan' => $total_permintaan,
            'permintaan_selesai' => $permintaan_selesai,
            'komoditas_stats' => $komoditas_stats,
            ];

            $this->load->view('distributor_index/index',$data);
            $this->load->view('distributor_index/header');
            $this->load->view('distributor/permintaan/index', $data);
            $this->load->view('distributor_index/permintaan_footer');
    }

    public function create() {
        $id_distributor = $this->session->userdata('id_distributor');
        
        $data = [
            'title' => 'Buat Permintaan Baru',
            'komoditas' => $this->Komoditas_model->get_all(),
            'validation_errors' => validation_errors() // Untuk menampilkan error validasi jika ada
        ];
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/permintaan/create', $data);
        $this->load->view('distributor_index/footer');
    }

    public function store() {
        $id_distributor = $this->session->userdata('id_distributor');
        $id_pengguna = $this->session->userdata('user_id');
        
        // Set rules validasi
        $this->form_validation->set_rules('id_komoditas', 'Komoditas', 'required|integer');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('harga_maks', 'Harga Maksimum', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form dengan error
            $this->create();
        } else {
            // Dapatkan data komoditas untuk aktivitas
            $komoditas = $this->Komoditas_model->get($this->input->post('id_komoditas'));
            
            // Siapkan data untuk disimpan
            $data = [
                'id_distributor' => $id_distributor,
                'id_komoditas' => $this->input->post('id_komoditas'),
                'jumlah' => $this->input->post('jumlah'),
                'harga_maks' => $this->input->post('harga_maks'),
                'sisa_permintaan' => $this->input->post('jumlah'),
                'status' => 'open',
                'dibuat_pada' => date('Y-m-d H:i:s')
            ];
            
            // Simpan ke database
            $id_permintaan = $this->Permintaan_model->create($data);
            
            if ($id_permintaan) {
                // Tambahkan aktivitas
                $pesan = "Permintaan baru untuk {$komoditas->nama_komoditas} sejumlah {$data['jumlah']} {$komoditas->satuan} telah dibuat";
                $this->Aktivitas_model->tambah_aktivitas(
                    $id_pengguna,
                    $id_distributor,
                    'permintaan',
                    $pesan
                );
                
                $this->session->set_flashdata('success', 'Permintaan berhasil dibuat!');
                redirect('distributor/permintaan/index');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat permintaan. Silakan coba lagi.');
                redirect('distributor/permintaan/create');
            }
        }
    }

    public function close($id) {
        $id_distributor = $this->session->userdata('id_distributor');
        $permintaan = $this->Permintaan_model->get($id);
        
        if ($permintaan && $permintaan->id_distributor == $id_distributor) {
            $this->Permintaan_model->update($id, ['status' => 'closed']);
            
            // Tambahkan aktivitas
            $komoditas = $this->Komoditas_model->get($permintaan->id_komoditas);
            $pesan = "Permintaan untuk {$komoditas->nama_komoditas} telah ditutup";
            $this->Aktivitas_model->tambah_aktivitas(
                $this->session->userdata('id_pengguna'),
                $id_distributor,
                'permintaan',
                $pesan
            );
            
            $this->session->set_flashdata('success', 'Permintaan berhasil ditutup');
        } else {
            $this->session->set_flashdata('error', 'Permintaan tidak ditemukan');
        }
        
        redirect('distributor/permintaan');
    }

    // Fungsi untuk AJAX get komoditas detail
    public function detail($id_permintaan) {
    $id_distributor = $this->session->userdata('id_distributor');
    
    // Ambil data permintaan
    $permintaan = $this->Permintaan_model->get_detail($id_permintaan, $id_distributor);
    
    if (!$permintaan) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header(404)
            ->set_output(json_encode(['error' => 'Permintaan tidak ditemukan']));
        return;
    }
    
    // Ambil data penawaran terkait
    $this->load->model('penawaran_model');
    $penawaran = $this->penawaran_model->get_by_detail($id_permintaan);
    
    // Hitung total yang sudah diterima
    $total_diterima = 0;
    foreach ($penawaran as $p) {
        // PERBAIKAN 1: Gunakan properti yang benar
        $jumlah = isset($p->jumlah_penawaran) ? $p->jumlah_penawaran : (isset($p->jumlah) ? $p->jumlah : 0);
        
        if ($p->status == 'accepted') {
            $total_diterima += $jumlah;
        }
    }
    
    $data = [
        'permintaan' => $permintaan,
        'penawaran' => $penawaran,
        'total_diterima' => $total_diterima
    ];
    
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
}

    
}
