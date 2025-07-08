<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
     public function __construct()
    {
        parent::__construct();
        $this->load->model('Permintaan_model');
        $this->load->model('Penawaran_model');
        $this->load->model('Penugasan_model');
        $this->load->model('Kurir_model');
        $this->load->model('Aktivitas_model');
        $this->load->library('form_validation');
        
        if(!$this->session->userdata('logged_in') || $this->session->userdata('peran') != 'distributor') {
            redirect('auth/login');
        }
    }
    public function index(){
        $id_distributor = $this->session->userdata('id_distributor');


		$permintaan = $this->Permintaan_model->get_with_komoditas(
            $id_distributor, 
            10, 
            1
        );
        
        foreach ($permintaan as $p) {
        $p->progres = ($p->jumlah > 0) 
            ? (($p->jumlah - $p->sisa_permintaan) / $p->jumlah) * 100 
            : 0;
        }
        

		$activity = $this->Aktivitas_model->get_recent_activities($id_distributor);
        
		if($activity == null) {
            $activity = [];
        }

        $data['user'] = array(
            'nama' => $this->session->userdata('nama'),
            'peran' => $this->session->userdata('peran'),
            'distributor_id' => $this->session->userdata('id_distributor'),
        );
        $data = [
            'title' => 'Dashboard Distributor',
			'permintaan' => $permintaan,
			'aktivitas_terbaru' => $activity,
            'permintaan_aktif' => $this->Permintaan_model->get_by_distributor($id_distributor, 'open'),
            'penawaran_baru' => $this->Penawaran_model->get_new_offers_for_distributor($id_distributor),
            'penugasan_kurir' => $this->Kurir_model->get_by_distributor($id_distributor),
            'butuh_verifikasi' => $this->Penugasan_model->get_assignments_for_verification($id_distributor),
            'nama' => $this->session->userdata('nama'),
            'nama_distributor' => $this->session->userdata('nama_distributor')
        ];
        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/dashboard');
        $this->load->view('distributor_index/footer');
    }
    public function test(){
        $this->load->view('errors/text_button');
    }
    
}
