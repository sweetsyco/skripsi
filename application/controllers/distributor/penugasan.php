<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penugasan_model');
        // Pastikan hanya distributor yang bisa akses
        if ($this->session->userdata('peran') != 'distributor') {
            redirect('login');
        }
    }

    public function index() {
        $id_distributor = $this->session->userdata('id_distributor');
        $data['title'] = "Manajemen Kurir";
        $data['penugasan'] = $this->penugasan_model->get_penugasan_by_distributor($id_distributor);
        $data['penawaran'] = $this->penugasan_model->get_accepted_penawaran($id_distributor);
        $data['kurir'] = $this->penugasan_model->get_kurir_by_distributor($id_distributor);
        
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/kurir/penugasan', $data);
        $this->load->view('distributor_index/footer');
    }

    public function create() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_penawaran', 'Penawaran', 'required');
        $this->form_validation->set_rules('id_kurir', 'Kurir', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('penugasan');
        }

        $data = array(
            'id_penawaran' => $this->input->post('id_penawaran'),
            'id_kurir' => $this->input->post('id_kurir'),
            'status' => 'pending',
            'ditugaskan_pada' => date('Y-m-d H:i:s')
        );

        if ($this->penugasan_model->create_penugasan($data)) {
            $this->session->set_flashdata('success', 'Penugasan berhasil dibuat!');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat penugasan');
        }
        redirect('penugasan');
    }

    public function update_status($id_penugasan, $status) {
        if ($this->penugasan_model->update_status($id_penugasan, $status)) {
            $this->session->set_flashdata('success', 'Status penugasan berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate status');
        }
        redirect('penugasan');
    }
}