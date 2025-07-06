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

    public function get_all_komoditas() {
        $this->db->order_by('nama_komoditas', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get($id) {
    return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }
    public function get_komoditas_by_id($id) {
        return $this->db->get_where('komoditas', ['id_komoditas' => $id])->row();
    }

    public function insert_komoditas($data) {
        $this->db->insert('komoditas', $data);
        return $this->db->insert_id();
    }

    public function update_komoditas($id, $data) {
        $this->db->where('id_komoditas', $id);
        $this->db->update('komoditas', $data);
        return $this->db->affected_rows();
    }

    public function delete_komoditas($id) {
        $this->db->where('id_komoditas', $id);
        $this->db->delete('komoditas');
        return $this->db->affected_rows();
    }
    public function is_used_in_permintaan($id_komoditas) {
    $this->db->where('id_komoditas', $id_komoditas);
    $count = $this->db->count_all_results('permintaan');
    return $count > 0;
    }
}