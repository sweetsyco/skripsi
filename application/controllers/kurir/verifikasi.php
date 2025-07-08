<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Penugasan_model');
        $this->load->library('form_validation');
        // Cek login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        } elseif ($this->session->userdata('peran') != 'kurir') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Verifikasi Penugasan - AgriConnect';
        $kurir = $this->session->userdata('id_kurir');
        $data['penugasan'] = $this->Penugasan_model->get_penugasan_by_kurir($kurir);

        $this->load->view('kurir_index/index',$data);
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/verifikasi/index', $data);
        $this->load->view('kurir_index/footer');
        
    }

    public function detail($id_penugasan) {
        $data['title'] = 'Detail Penugasan';
        $data['penugasan'] = $this->Penugasan_model->get_penugasan_detail($id_penugasan);
        
        $this->load->view('kurir_index/index', $data);
        $this->load->view('kurir_index/header');
        $this->load->view('kurir/verifikasi/detail', $data);
        $this->load->view('kurir_index/footer');
    }

    public function upload_bukti($id_penugasan) {
        $data['title'] = 'Upload Bukti Pengiriman';
        $data['penugasan'] = $this->Penugasan_model->get_penugasan_by_id($id_penugasan);

        $this->form_validation->set_rules('catatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('kurir_index/index', $data);
            $this->load->view('kurir_index/header');
            $this->load->view('kurir/verifikasi/upload', $data);
            $this->load->view('kurir_index/footer');
        } else {
            // Proses upload foto
            $config['upload_path'] = './uploads/bukti/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto_bukti')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('kurir_index/index', $data);
                $this->load->view('kurir_index/header');
                $this->load->view('kurir/verifikasi/upload', $data);
                $this->load->view('kurir_index/footer');
            } else {
                $upload_data = $this->upload->data();
                $foto_bukti = $upload_data['file_name'];

                $data = array(
                    'foto_bukti' => $foto_bukti,
                    'catatan' => $this->input->post('catatan'),
                    'waktu_bukti' => date('Y-m-d H:i:s'),
                    'status' => 'pending',
                );

                $this->Penugasan_model->upload_bukti($id_penugasan, $data);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Bukti berhasil diupload! Penugasan selesai.</div>');
                redirect('kurir/verifikasi');
            }
        }
    }
}