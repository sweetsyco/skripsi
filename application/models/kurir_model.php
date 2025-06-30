<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurir_model extends CI_Model {
    protected $table = 'kurir';

    public function __construct() {
        parent::__construct();
    }

    public function insert($kurir_data) {
        $this->db->insert($this->table, $kurir_data);
        return $this->db->insert_id();
    }

    public function getByUserId($user_id) {
    $this->db->where('id_pengguna', $user_id);
    return $this->db->get('kurir')->row(); // Mengembalikan objek
    }

    public function get_by_distributor($id_distributor) {
        $this->db->where('id_distributor', $id_distributor);
        return $this->db->get($this->table)->result();
    }

    public function get_with_pengguna($id_distributor) {
        $this->db->select('kurir.*, pengguna.nama, pengguna.email');
        $this->db->from('kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->where('kurir.id_distributor', $id_distributor);
        return $this->db->get()->result();
    }

    public function get_kurir_by_distributor($id_distributor) {
        $this->db->select('kurir.*, pengguna.nama, pengguna.email');
        $this->db->from('kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->where('kurir.id_distributor', $id_distributor);
        return $this->db->get()->result();
    }

    public function get_detail_kurir($id_kurir, $id_distributor) {
    $this->db->select('kurir.*, pengguna.nama, pengguna.email, pengguna.id_pengguna');
    $this->db->from('kurir');
    $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
    $this->db->where('kurir.id_kurir', $id_kurir);
    $this->db->where('kurir.id_distributor', $id_distributor);
    return $this->db->get()->row();
    }

    
}

