<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Komoditas_model');
        if (!$this->session->userdata('user_id') || $this->session->userdata('peran') != 'distributor') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Komoditas';
        $data['komoditas'] = $this->Komoditas_model->get_all_komoditas();
        
        
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/komoditas/index', $data);
        $this->load->view('distributor_index/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Komoditas';

        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('distributor_index/index',$data);
            $this->load->view('distributor_index/header');
            $this->load->view('distributor/komoditas/create', $data);
            $this->load->view('distributor_index/footer');
        } else {
            $data = [
                'nama_komoditas' => $this->input->post('nama_komoditas'),
                'satuan' => $this->input->post('satuan')
            ];
            
            $this->Komoditas_model->insert_komoditas($data);
            $this->session->set_flashdata('success', 'Komoditas berhasil ditambahkan.');
            redirect('distributor/komoditas');
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit Komoditas';
        $data['komoditas'] = $this->Komoditas_model->get_komoditas_by_id($id);

        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('distributor_index/index',$data);
            $this->load->view('distributor_index/header');
            $this->load->view('distributor/komoditas/update', $data);
            $this->load->view('distributor_index/footer');
        } else {
            $data = [
                'nama_komoditas' => $this->input->post('nama_komoditas'),
                'satuan' => $this->input->post('satuan')
            ];
            
            $this->Komoditas_model->update_komoditas($id, $data);
            $this->session->set_flashdata('success', 'Komoditas berhasil diperbarui.');
            redirect('distributor/komoditas');
        }
    }

    public function hapus($id) {
    // Cek apakah komoditas digunakan di tabel permintaan
    if ($this->Komoditas_model->is_used_in_permintaan($id)) {
        $this->session->set_flashdata('error', 'Komoditas tidak dapat dihapus karena masih terkait dengan data permintaan.');
    } else {
        $this->Komoditas_model->delete_komoditas($id);
        $this->session->set_flashdata('success', 'Komoditas berhasil dihapus.');
    }
    redirect('distributor/komoditas');
    }      
}