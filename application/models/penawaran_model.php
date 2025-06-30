<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penawaran_model extends CI_Model {

    protected $table = 'penawaran';
    protected $primaryKey = 'id_penawaran';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_permintaan($id_permintaan, $status = null) {
        $this->db->where('id_permintaan', $id_permintaan);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('dibuat_pada', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_with_petani($id_permintaan) {
        $this->db->select('penawaran.*, petani.alamat, petani.no_telepon, pengguna.nama');
        $this->db->from('penawaran');
        $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
        $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
        $this->db->where('penawaran.id_permintaan', $id_permintaan);
        return $this->db->get()->result();
    }

    public function get_new_offers_for_distributor($id_distributor) {
        $this->db->select('penawaran.*, permintaan.id_distributor, pengguna.nama as nama_petani');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
        $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->where('penawaran.status', 'pending');
        return $this->db->get()->result();
    }

    public function update($id, $data) {
        $this->db->where($this->primaryKey, $id);
        $this->db->update($this->table, $data);
    }

    public function get_statistik($id_distributor) {
    $this->db->select("
        COUNT(*) as total,
        SUM(CASE WHEN pn.status = 'accepted' THEN 1 ELSE 0 END) as accepted,
        SUM(CASE WHEN pn.status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN pn.status = 'rejected' THEN 1 ELSE 0 END) as rejected
    ");
    $this->db->from('penawaran pn');
    $this->db->join('permintaan pm', 'pn.id_permintaan = pm.id_permintaan');
    $this->db->where('pm.id_distributor', $id_distributor);
    
    return $this->db->get()->row_array();
    }

    public function get_penawaran_by_filters($id_distributor, $filters) {
    $this->db->select('
        pn.id_penawaran,
        pn.jumlah,
        pn.harga AS harga_per_kg, 
        (pn.jumlah * pn.harga) AS total_harga,  
        pn.status,
        pn.dibuat_pada,
        k.nama_komoditas,
        pg.nama AS nama_petani
    ');
    $this->db->from('penawaran pn');
    $this->db->join('permintaan pm', 'pn.id_permintaan = pm.id_permintaan');
    $this->db->join('komoditas k', 'pm.id_komoditas = k.id_komoditas');
    $this->db->join('petani pt', 'pn.id_petani = pt.id_petani');
    $this->db->join('pengguna pg', 'pt.id_pengguna = pg.id_pengguna');
    $this->db->where('pm.id_distributor', $id_distributor);
    
    // Filter status
    if (!empty($filters['status']) && $filters['status'] != 'all') {
        $this->db->where('penawaran.status', $filters['status']);
    }
    
    // Filter komoditas
    if (!empty($filters['komoditas']) && $filters['komoditas'] != 'all') {
        $this->db->where('komoditas.nama_komoditas', $filters['komoditas']);
    }
    
    // Pencarian
    if (!empty($filters['pencarian'])) {
        $this->db->group_start();
        $this->db->like('komoditas.nama_komoditas', $filters['pencarian']);
        $this->db->or_like('pengguna.nama', $filters['pencarian']); // Cari di nama pengguna
        $this->db->group_end();
    }
    
    // Urutan
    if ($filters['urutan'] == 'terlama') {
        $this->db->order_by('pn.dibuat_pada', 'ASC');
    } else {
        $this->db->order_by('pn.dibuat_pada', 'DESC');
    }
    
    return $this->db->get()->result_array();
    }

    public function get_by_id($id_penawaran) {
    $this->db->select('id_penawaran, id_permintaan, jumlah, status');
    return $this->db->get_where('penawaran', ['id_penawaran' => $id_penawaran])->row_array();
    }
    public function get_penawaran_by_petani($id_petani) {
        $this->db->select('
            pn.*,
            pm.sisa_permintaan,
            k.nama_komoditas,
            d.nama_perusahaan,
            pm.jumlah AS jumlah_permintaan
        ');
        $this->db->from('penawaran pn');
        $this->db->join('permintaan pm', 'pn.id_permintaan = pm.id_permintaan');
        $this->db->join('komoditas k', 'pm.id_komoditas = k.id_komoditas');
        $this->db->join('distributor d', 'pm.id_distributor = d.id_distributor');
        $this->db->where('pn.id_petani', $id_petani);
        $this->db->order_by('pn.dibuat_pada', 'DESC');
        return $this->db->get()->result_array();
    }

    // Buat penawaran baru
    public function create_penawaran($data) {
        $this->db->insert('penawaran', $data);
        return $this->db->insert_id();
    }

    // Ambil satu penawaran berdasarkan ID
    public function get_penawaran_by_id($id_penawaran, $id_petani) {
        $this->db->select('penawaran.*, permintaan.id_komoditas, permintaan.jumlah as jumlah_permintaan, permintaan.harga_maks, komoditas.nama_komoditas, distributor.nama_perusahaan');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
        $this->db->where('penawaran.id_penawaran', $id_penawaran);
        $this->db->where('penawaran.id_petani', $id_petani);
        return $this->db->get()->row_array();
    }

    // Update penawaran
    public function update_penawaran($id_penawaran, $id_petani, $data) {
        $this->db->where('id_penawaran', $id_penawaran);
        $this->db->where('id_petani', $id_petani);
        return $this->db->update('penawaran', $data);
    }

    // Hapus penawaran
    public function delete_penawaran($id_penawaran, $id_petani) {
        $this->db->where('id_penawaran', $id_penawaran);
        $this->db->where('id_petani', $id_petani);
        $this->db->delete('penawaran');
        return $this->db->affected_rows();
    }
    public function get_status_counts($id_petani) {
    $statuses = ['pending', 'accepted', 'rejected'];
    $results = [];
    
    foreach ($statuses as $status) {
        $this->db->where('id_petani', $id_petani);
        $this->db->where('status', $status);
        $results[$status] = $this->db->count_all_results('penawaran');
    }
    
    $results['total'] = array_sum($results);
    
    return $results;
}
public function get_all_komoditas() {
    $this->db->select('nama_komoditas');
    $this->db->from('komoditas');
    $this->db->order_by('nama_komoditas', 'ASC');
    return $this->db->get()->result_array();
}
public function update_status($id_penawaran, $status) {
    $this->db->where('id_penawaran', $id_penawaran);
    return $this->db->update('penawaran', ['status' => $status]);
}
// application/models/Penawaran_model.php

public function get_by_detail($id_permintaan) {
    $this->db->select('
        penawaran.*, 
        pengguna.nama AS nama_petani,
        penawaran.jumlah AS jumlah_penawaran
    ');
    $this->db->from('penawaran');
    $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
    $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna'); // Join ke tabel pengguna
    $this->db->where('penawaran.id_permintaan', $id_permintaan);
    return $this->db->get()->result();
}

public function get_komoditas_detail($id_penawaran) {
    $this->db->select('komoditas.nama_komoditas, komoditas.satuan');
    $this->db->from('penawaran');
    $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
    $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
    $this->db->where('penawaran.id_penawaran', $id_penawaran);
    return $this->db->get()->row();
}
}
