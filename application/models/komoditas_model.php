<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas_model extends CI_Model {

    protected $table = 'komoditas';
    protected $primaryKey = 'id_komoditas';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->order_by('nama_komoditas', 'ASC');
        return $this->db->get($this->table)->result();
    }
    public function get($id) {
    return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
}
}