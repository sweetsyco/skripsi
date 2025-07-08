<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan_model extends CI_Model {

    protected $table = 'permintaan';
    protected $primaryKey = 'id_permintaan';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_distributor($id_distributor, $status = null) {
        $this->db->where('id_distributor', $id_distributor);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('dibuat_pada', 'DESC');
        return $this->db->get($this->table)->result();
    }

    public function get_with_komoditas($id_distributor) {
        $this->db->select('permintaan.*, komoditas.nama_komoditas, komoditas.satuan');
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'permintaan.id_komoditas = komoditas.id_komoditas');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->order_by('permintaan.dibuat_pada', 'DESC');
        return $this->db->get()->result();
    }

    public function update_sisa_permintaan($id_permintaan, $jumlah) {
        $permintaan = $this->db->get_where($this->table, [$this->primaryKey => $id_permintaan])->row();
        $sisa = $permintaan->sisa_permintaan - $jumlah;
        
        if ($sisa <= 0) {
            $this->db->update($this->table, 
                ['sisa_permintaan' => 0, 'status' => 'closed'], 
                [$this->primaryKey => $id_permintaan]
            );
        } else {
            $this->db->update($this->table, 
                ['sisa_permintaan' => $sisa], 
                [$this->primaryKey => $id_permintaan]
            );
        }
    }

    public function get_komoditas_stats($id_distributor) {
        $this->db->select('komoditas.nama_komoditas, COUNT(permintaan.id_permintaan) as jumlah_permintaan');
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->group_by('permintaan.id_komoditas');
        return $this->db->get()->result();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where($this->primaryKey, $id);
        $this->db->update($this->table, $data);
    }

    public function get($id) {
        return $this->db->get_where($this->table, [$this->primaryKey => $id])->row();
    }
    public function get_active_permintaan() {
        $this->db->select('permintaan.*, 
                        komoditas.nama_komoditas, 
                        distributor.nama_perusahaan as nama_distributor');
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
        $this->db->where('permintaan.status', 'open');
        return $this->db->get()->result_array();
    }

    public function get_permintaan_by_id($id_permintaan) {
        $this->db->select('permintaan.*, 
                        komoditas.nama_komoditas, 
                        distributor.nama_perusahaan as nama_distributor'); 
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
        $this->db->where('permintaan.id_permintaan', $id_permintaan);
        return $this->db->get()->row_array();
    }
    public function get_by_id($id_permintaan) {
        return $this->db->get_where('permintaan', ['id_permintaan' => $id_permintaan])->row_array();
    }

    public function update_sisa($id_permintaan, $sisa_baru) {
        $this->db->where('id_permintaan', $id_permintaan);
        return $this->db->update('permintaan', ['sisa_permintaan' => $sisa_baru]);
    }

    public function update_status($id_permintaan, $status) {
        $this->db->where('id_permintaan', $id_permintaan);
        return $this->db->update('permintaan', ['status' => $status]);
    }

    public function get_detail($id_permintaan, $id_distributor) {
    $this->db->select('permintaan.*, komoditas.nama_komoditas, komoditas.satuan');
    $this->db->from('permintaan');
    $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
    $this->db->where('permintaan.id_permintaan', $id_permintaan);
    $this->db->where('permintaan.id_distributor', $id_distributor);
    return $this->db->get()->row();
}
    
    public function count_by_distributor($id_distributor) {
        $this->db->where('id_distributor', $id_distributor);
        return $this->db->count_all_results('permintaan');
    }

    public function get_with_komoditas_paginated($id_distributor, $limit, $offset) {
        $this->db->select('permintaan.*, komoditas.nama_komoditas, komoditas.satuan');
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->order_by('permintaan.dibuat_pada', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_closed_by_distributor($id_distributor) {
        $this->db->where('id_distributor', $id_distributor);
        $this->db->where('status', 'closed');
        return $this->db->count_all_results('permintaan');
    }
    
}