<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurir extends CI_Controller {

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
	
    public function dashboard(){
        $data['title'] = 'Dashboard Kurir';
        $data['user'] = array(
            'nama' => $this->session->userdata('nama'),
            'peran' => $this->session->userdata('peran'),
            'distributor_id' => $this->session->userdata('distributor_id')
        );
        $this->load->view('kurir_index/index',$data);
        $this->load->view('kurir_index/header');
        $this->load->view('distributor/dashboard');
        $this->load->view('kurir_index/footer');
    }
}
