<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penawaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('penawaran_model');
        // Cek login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
         $id_distributor = $this->session->userdata('id_distributor');
        $filters = [
        'status' => $this->input->get('status'),
        'komoditas' => $this->input->get('komoditas'),
        'urutan' => $this->input->get('urutan'),
        'pencarian' => $this->input->get('pencarian')
    ];
    
    // Ambil data dari model
    $data = [
        'title' => 'Manajemen Penawaran',
        'statistik' => $this->penawaran_model->get_statistik($id_distributor),
        'penawaran' => $this->penawaran_model->get_penawaran_by_filters($id_distributor, $filters),
        'komoditas_list' => $this->penawaran_model->get_all_komoditas()
    ];
    
    $this->load->view('distributor_index/index',$data);
    $this->load->view('distributor_index/header');
    $this->load->view('distributor/penawaran/index', $data);
    $this->load->view('distributor_index/penawaran_footer');
    }

    public function update_status() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $id_penawaran = $this->input->post('id_penawaran');
    $status_baru = $this->input->post('status_baru');

    if (empty($id_penawaran) || empty($status_baru)) {
        echo json_encode(['sukses' => false, 'pesan' => 'Permintaan tidak valid']);
        return;
    }

    // Load model tambahan
    $this->load->model('permintaan_model');

    // Dapatkan data penawaran
    $penawaran = $this->penawaran_model->get_by_id($id_penawaran);
    if (!$penawaran || $penawaran['status'] != 'pending') {
        echo json_encode(['sukses' => false, 'pesan' => 'Penawaran tidak ditemukan atau sudah diproses']);
        return;
    }

    // Mulai transaksi database
    $this->db->trans_begin();

    try {
        // Update status penawaran
        $this->penawaran_model->update_status($id_penawaran, $status_baru);

        // Jika status diterima, kurangi sisa permintaan
        if ($status_baru == 'accepted') {
            // Dapatkan data permintaan terkait
            $permintaan = $this->permintaan_model->get_by_id($penawaran['id_permintaan']);
            
            if ($permintaan) {
                $sisa_baru = $permintaan['sisa_permintaan'] - $penawaran['jumlah'];
                
                // Pastikan tidak minus
                if ($sisa_baru < 0) {
                    throw new Exception("Jumlah penawaran melebihi sisa permintaan");
                }
                
                // Update sisa permintaan
                $this->permintaan_model->update_sisa(
                    $penawaran['id_permintaan'], 
                    $sisa_baru
                );
                
                // Jika sisa = 0, tutup permintaan
                if ($sisa_baru == 0) {
                    $this->permintaan_model->update_status(
                        $penawaran['id_permintaan'], 
                        'closed'
                    );
                }
            }
        }

        // Commit transaksi jika semua berhasil
        $this->db->trans_commit();
        echo json_encode(['sukses' => true]);
        
    } catch (Exception $e) {
        // Rollback jika ada error
        $this->db->trans_rollback();
        echo json_encode(['sukses' => false, 'pesan' => $e->getMessage()]);
    }
}
}