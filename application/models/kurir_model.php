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

     public function get_kurir_by_user_id($id_pengguna) {
        $this->db->select('kurir.*, pengguna.nama, pengguna.email');
        $this->db->from('kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->where('kurir.id_pengguna', $id_pengguna);
        return $this->db->get()->row();
    }

    // Mendapatkan penugasan aktif untuk kurir (FIXED)
    public function get_active_assignments($id_kurir) {
        $this->db->select('penugasan.*, penawaran.jumlah, penawaran.harga, 
                           pengguna.nama as nama_petani, 
                           distributor.nama_perusahaan,
                           distributor.alamat as alamat_distributor, 
                           komoditas.nama_komoditas, 
                           petani.alamat as alamat_pengambilan,
                           petani.no_telepon as telepon_petani');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
        $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
        $this->db->where('penugasan.id_kurir', $id_kurir);
        $this->db->where_in('penugasan.status', ['pending', 'pick up']); 
        return $this->db->get()->result();
    }

    // Mendapatkan statistik penugasan
    public function get_assignment_stats($id_kurir) {
        $stats = [
            'total' => 0,
            'pick up' => 0, 
            'approved' => 0, 
            'pending' => 0
        ];

        $this->db->select('status, COUNT(*) as count');
        $this->db->from('penugasan');
        $this->db->where('id_kurir', $id_kurir);
        $this->db->group_by('status');
        $result = $this->db->get()->result();

        foreach ($result as $row) {
            $stats['total'] += $row->count;
            switch ($row->status) {
                case 'pick up': // status baru
                    $stats['pick up'] = $row->count;
                    break;
                case 'approved': // status final
                    $stats['approved'] = $row->count;
                    break;
                case 'pending':
                    $stats['pending'] = $row->count;
                    break;
            }
        }

        return $stats;
    }

    // Memperbarui status penugasan
    public function update_assignment_status($id_penugasan, $status) {
        $this->db->set('status', $status);
        $this->db->where('id_penugasan', $id_penugasan);
        return $this->db->update('penugasan');
    }

    public function get_assignment_details($id_penugasan) {
    $this->db->select('penugasan.*, penawaran.jumlah, penawaran.harga, 
                       pengguna.nama as nama_petani, 
                       distributor.nama_perusahaan, 
                       distributor.alamat as alamat_distributor,
                       komoditas.nama_komoditas, 
                       petani.alamat as alamat_pengambilan,
                       petani.no_telepon as telepon_petani');
    $this->db->from('penugasan');
    $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
    $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
    $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
    $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
    $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
    $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
    $this->db->where('penugasan.id_penugasan', $id_penugasan);
    return $this->db->get()->row();
}

public function complete_assignment($id_penugasan, $data) {
    $this->db->set('status', 'approved');
    $this->db->set('catatan', $data['catatan']);
    $this->db->set('diverifikasi_pada', date('Y-m-d H:i:s'));
    
    if (!empty($data['foto_bukti'])) {
        $this->db->set('foto_bukti', $data['foto_bukti']);
    }
    
    $this->db->where('id_penugasan', $id_penugasan);
    return $this->db->update('penugasan');
}
public function get_by_pengguna($id_pengguna) {
        $this->db->select('kurir.*, pengguna.nama, pengguna.email, pengguna.dibuat_pada, distributor.nama_perusahaan');
        $this->db->from('kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->join('distributor', 'distributor.id_distributor = kurir.id_distributor');
        $this->db->where('kurir.id_pengguna', $id_pengguna);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update($id_kurir, $data) {
        $this->db->where('id_kurir', $id_kurir);
        return $this->db->update('kurir', $data);
    }

    public function count_penugasan_aktif($id_kurir) {
        $this->db->where('id_kurir', $id_kurir);
        $this->db->where('status', 'pick up'); 
        return $this->db->count_all_results('penugasan');
    }

    public function count_total_penugasan($id_kurir) {
        $this->db->where('id_kurir', $id_kurir);
        return $this->db->count_all_results('penugasan');
    }

    
}

