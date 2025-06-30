<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan_model extends CI_Model {

    protected $table = 'penugasan';
    protected $primaryKey = 'id_penugasan';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_penawaran($id_penawaran) {
        return $this->db->get_where($this->table, ['id_penawaran' => $id_penawaran])->row();
    }

    public function get_assignments_for_verification($id_distributor) {
        $this->db->select('penugasan.*, penawaran.id_permintaan, permintaan.id_distributor, pengguna.nama as nama_kurir');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('kurir', 'kurir.id_kurir = penugasan.id_kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->where('penugasan.status', 'pending');
        return $this->db->get()->result();
    }
    public function get_laporan_penugasan($id_distributor) {
        $this->db->select('penugasan.*, penawaran.jumlah, komoditas.nama_komoditas, pengguna.nama AS nama_kurir, pengguna_petani.nama AS nama_petani, penugasan.catatan, penugasan.foto_bukti');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->join('kurir', 'kurir.id_kurir = penugasan.id_kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
        $this->db->join('pengguna AS pengguna_petani', 'pengguna_petani.id_pengguna = petani.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        return $this->db->get()->result();
    }

   public function get_penugasan_by_distributor($id_distributor) {
        $this->db->select('penugasan.*, penawaran.jumlah, penawaran.harga, 
                          pengguna_kurir.nama as nama_kurir, 
                          pengguna_petani.nama as nama_petani, 
                          komoditas.nama_komoditas');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penugasan.id_penawaran = penawaran.id_penawaran');
        $this->db->join('permintaan', 'penawaran.id_permintaan = permintaan.id_permintaan');
        $this->db->join('komoditas', 'permintaan.id_komoditas = komoditas.id_komoditas');
        $this->db->join('kurir', 'penugasan.id_kurir = kurir.id_kurir');
        $this->db->join('pengguna as pengguna_kurir', 'kurir.id_pengguna = pengguna_kurir.id_pengguna');
        $this->db->join('petani', 'penawaran.id_petani = petani.id_petani');
        $this->db->join('pengguna as pengguna_petani', 'petani.id_pengguna = pengguna_petani.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        return $this->db->get()->result_array();
    }

    public function get_accepted_penawaran($id_distributor) {
        $this->db->select('penawaran.*, pengguna.nama as nama_petani, komoditas.nama_komoditas');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'penawaran.id_permintaan = permintaan.id_permintaan');
        $this->db->join('komoditas', 'permintaan.id_komoditas = komoditas.id_komoditas');
        $this->db->join('petani', 'penawaran.id_petani = petani.id_petani');
        $this->db->join('pengguna', 'petani.id_pengguna = pengguna.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->where('penawaran.status', 'accepted');
        $this->db->where('NOT EXISTS (SELECT 1 FROM penugasan WHERE penugasan.id_penawaran = penawaran.id_penawaran)', NULL, FALSE);
        return $this->db->get()->result_array();
    }

    public function get_kurir_by_distributor($id_distributor) {
        $this->db->select('kurir.*, pengguna.nama');
        $this->db->from('kurir');
        $this->db->join('pengguna', 'kurir.id_pengguna = pengguna.id_pengguna');
        $this->db->where('kurir.id_distributor', $id_distributor);
        return $this->db->get()->result_array();
    }

    public function create_penugasan($data) {
        $this->db->insert('penugasan', $data);
        return $this->db->insert_id();
    }

    public function update_status($id_penugasan, $status) {
        $this->db->set('status', $status);
        $this->db->set('diverifikasi_pada', date('Y-m-d H:i:s'));
        $this->db->where('id_penugasan', $id_penugasan);
        return $this->db->update('penugasan');
    }
}
