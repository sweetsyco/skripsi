<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petani_model extends CI_Model {
    protected $table = 'petani';

    public function __construct() {
        parent::__construct();
    }

    public function insert($petani_data) {
        $this->db->insert($this->table, $petani_data);
        return $this->db->insert_id();
    }

    public function getByUserId($user_id) {
    $this->db->where('id_pengguna', $user_id);
    return $this->db->get('petani')->row(); // Mengembalikan objek
    }

    public function get_stats($id_petani) {
        $stats = [
            'permintaan_aktif' => $this->count_open_permintaan(),
            'penawaran_saya'   => $this->count_penawaran_petani($id_petani),
            'penugasan_kurir'  => $this->count_penugasan_petani($id_petani),
            'jenis_komoditas'  => $this->count_komoditas_petani($id_petani)
        ];
        return $stats;
    }

    // Hitung permintaan aktif
    private function count_open_permintaan() {
        $this->db->where('status', 'open');
        return $this->db->count_all_results('permintaan');
    }

    // Hitung penawaran petani
    private function count_penawaran_petani($id_petani) {
        $this->db->where('id_petani', $id_petani);
        return $this->db->count_all_results('penawaran');
    }

    // Hitung penugasan untuk petani
    private function count_penugasan_petani($id_petani) {
        $this->db->select('penugasan.*');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->where('penawaran.id_petani', $id_petani);
        return $this->db->count_all_results();
    }

    // Hitung jenis komoditas
    private function count_komoditas_petani($id_petani) {
        $this->db->select('COUNT(DISTINCT komoditas.id_komoditas) as total');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->where('penawaran.id_petani', $id_petani);
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    // Ambil permintaan terbaru
    public function get_recent_permintaan() {
    $this->db->select('permintaan.*, komoditas.nama_komoditas, distributor.nama_perusahaan');
    $this->db->from('permintaan');
    $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
    $this->db->join('distributor', 'distributor.id_distributor = permintaan.id_distributor');
    $this->db->where('permintaan.status', 'open');
    $this->db->order_by('dibuat_pada', 'DESC');
    $this->db->limit(5);
    $query = $this->db->get();
    
    // Pastikan selalu return array
    return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    // Ambil aktivitas terbaru
    public function get_recent_activities() {
    $this->db->order_by('waktu', 'DESC');
    $this->db->limit(5);
    $query = $this->db->get('aktivitas');
    return $query->num_rows() > 0 ? $query->result_array() : [];
    }

    // Ambil data petani berdasarkan ID pengguna
    public function get_petani_data($id_pengguna) {
        $this->db->select('petani.*, pengguna.nama');
        $this->db->from('petani');
        $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
        $this->db->where('petani.id_pengguna', $id_pengguna);
        return $this->db->get()->row_array();
    }

    public function get_by_pengguna($id_pengguna) {
        $this->db->select('petani.*, pengguna.nama, pengguna.email, pengguna.dibuat_pada');
        $this->db->from('petani');
        $this->db->join('pengguna', 'petani.id_pengguna = pengguna.id_pengguna');
        $this->db->where('petani.id_pengguna', $id_pengguna);
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function update($id_petani, $data) {
        $this->db->where('id_petani', $id_petani);
        return $this->db->update('petani', $data);
    }

    public function get_profile($id_petani) {
        $stats = array();

        // Hitung jumlah permintaan aktif
        $this->db->select('COUNT(*) as total');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'penawaran.id_permintaan = permintaan.id_permintaan');
        $this->db->where('penawaran.id_petani', $id_petani);
        $this->db->where('permintaan.status', 'open');
        $this->db->where('penawaran.status', 'pending');
        $query = $this->db->get();
        $stats['permintaan_aktif'] = $query->row()->total;

        // Hitung jumlah penawaran
        $this->db->select('COUNT(*) as total');
        $this->db->from('penawaran');
        $this->db->where('id_petani', $id_petani);
        $query = $this->db->get();
        $stats['total_penawaran'] = $query->row()->total;

        // Hitung penugasan kurir
        $this->db->select('COUNT(*) as total');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penugasan.id_penawaran = penawaran.id_penawaran');
        $this->db->where('penawaran.id_petani', $id_petani);
        $this->db->where('penugasan.status', 'approved');
        $query = $this->db->get();
        $stats['penugasan_kurir'] = $query->row()->total;

        // Hitung jenis komoditas
        $this->db->select('COUNT(DISTINCT permintaan.id_komoditas) as total');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'penawaran.id_permintaan = permintaan.id_permintaan');
        $this->db->where('penawaran.id_petani', $id_petani);
        $query = $this->db->get();
        $stats['jenis_komoditas'] = $query->row()->total;

        return $stats;
    }
}