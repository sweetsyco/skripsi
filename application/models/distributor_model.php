<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor_model extends CI_Model {
    protected $table = 'distributor';

    public function __construct() {
        parent::__construct();
        $table = 'distributor';
    }

    public function insert($distributor_data) {
        $this->db->insert($this->table, $distributor_data);
        return $this->db->insert_id();
    }

    public function getByUserId($user_id) {
    $this->db->where('id_pengguna', $user_id);
    return $this->db->get('distributor')->row(); // Mengembalikan objek
    }


    public function get_all() {
        $this->db->select('distributor.id, distributor.nama_perusahaan, pengguna.nama');
        $this->db->from($this->table);
        $this->db->join('pengguna', 'pengguna.id = distributor.id_pengguna');
        $this->db->order_by('distributor.nama_perusahaan', 'ASC');
        return $this->db->get()->result();
    }
    public function get_distributor_by_id($id_distributor) {
        $this->db->where('id_distributor', $id_distributor);
        return $this->db->get('distributor')->row();
    }
    public function get_recent_activities() {
        $this->db->where_in('jenis', ['penugasan','verifikasi', 'penawaran']); 
        $this->db->order_by('waktu', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get('aktivitas');
        return $query->num_rows() > 0 ? $query->result_array() : [];
    }
}