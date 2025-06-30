<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class D_Report_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_komoditas() {
        return $this->db->get('komoditas')->result();
    }

    public function get_total_permintaan($id_distributor, $filter) {
        $this->apply_filters($id_distributor, $filter);
        return $this->db->count_all_results('permintaan');
    }

    public function get_permintaan_selesai($id_distributor, $filter) {
        $this->apply_filters($id_distributor, $filter);
        $this->db->where('status', 'closed');
        return $this->db->count_all_results('permintaan');
    }

    public function get_total_penawaran($id_distributor, $filter) {
        $this->apply_filters_penawaran($id_distributor, $filter);
        return $this->db->count_all_results('penawaran');
    }

    public function get_pengiriman_selesai($id_distributor, $filter) {
        $this->apply_filters_penugasan($id_distributor, $filter);
        $this->db->where('penugasan.status', 'approved');
        return $this->db->count_all_results('penugasan');
    }

    public function get_grafik_permintaan($id_distributor, $filter) {
        $this->apply_filters($id_distributor, $filter);
        $this->db->select("DATE_FORMAT(dibuat_pada, '%b') AS bulan, 
                          COUNT(*) AS total_aktif,
                          SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS total_selesai");
        $this->db->group_by("DATE_FORMAT(dibuat_pada, '%m'), DATE_FORMAT(dibuat_pada, '%b')");
        $this->db->order_by("MONTH(dibuat_pada)", 'ASC');
        return $this->db->get('permintaan')->result();
    }

    public function get_distribusi_komoditas($id_distributor, $filter) {
        $this->apply_filters($id_distributor, $filter);
        $this->db->select('komoditas.nama_komoditas, COUNT(permintaan.id_permintaan) AS jumlah');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->group_by('permintaan.id_komoditas');
        return $this->db->get('permintaan')->result();
    }

    public function get_laporan_permintaan($id_distributor, $filter) {
        $this->apply_filters($id_distributor, $filter);
        $this->db->select('permintaan.*, komoditas.nama_komoditas,
                          (SELECT COUNT(*) FROM penawaran WHERE penawaran.id_permintaan = permintaan.id_permintaan) AS jumlah_penawaran,
                          (SELECT SUM(penawaran.jumlah) FROM penawaran 
                           WHERE penawaran.id_permintaan = permintaan.id_permintaan 
                           AND penawaran.status = "accepted") AS jumlah_diterima,
                          (SELECT COUNT(*) FROM penugasan 
                           JOIN penawaran ON penawaran.id_penawaran = penugasan.id_penawaran 
                           WHERE penawaran.id_permintaan = permintaan.id_permintaan) AS jumlah_pengiriman');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->order_by('dibuat_pada', 'DESC');
        return $this->db->get('permintaan')->result();
    }

    private function apply_filters($id_distributor, $filter) {
        $this->db->where('permintaan.id_distributor', $id_distributor);

        if(!empty($filter['start_date'])) {
            $this->db->where('dibuat_pada >=', $filter['start_date']);
        }

        if(!empty($filter['end_date'])) {
            $this->db->where('dibuat_pada <=', $filter['end_date']);
        }

        if(!empty($filter['status']) && $filter['status'] != 'all') {
            $this->db->where('permintaan.status', $filter['status']);
        }

        if(!empty($filter['id_komoditas']) && $filter['id_komoditas'] != 'all') {
            $this->db->where('permintaan.id_komoditas', $filter['id_komoditas']);
        }
    }

    private function apply_filters_penawaran($id_distributor, $filter) {
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->where('permintaan.id_distributor', $id_distributor);

        if(!empty($filter['start_date'])) {
            $this->db->where('permintaan.dibuat_pada >=', $filter['start_date']);
        }

        if(!empty($filter['end_date'])) {
            $this->db->where('permintaan.dibuat_pada <=', $filter['end_date']);
        }

        if(!empty($filter['status']) && $filter['status'] != 'all') {
            $this->db->where('permintaan.status', $filter['status']);
        }

        if(!empty($filter['id_komoditas']) && $filter['id_komoditas'] != 'all') {
            $this->db->where('permintaan.id_komoditas', $filter['id_komoditas']);
        }
    }

    private function apply_filters_penugasan($id_distributor, $filter) {
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->where('permintaan.id_distributor', $id_distributor);

        if(!empty($filter['start_date'])) {
            $this->db->where('permintaan.dibuat_pada >=', $filter['start_date']);
        }

        if(!empty($filter['end_date'])) {
            $this->db->where('permintaan.dibuat_pada <=', $filter['end_date']);
        }

        if(!empty($filter['status']) && $filter['status'] != 'all') {
            $this->db->where('permintaan.status', $filter['status']);
        }

        if(!empty($filter['id_komoditas']) && $filter['id_komoditas'] != 'all') {
            $this->db->where('permintaan.id_komoditas', $filter['id_komoditas']);
        }
    }
    public function get_komoditas_name($id_komoditas) {
        // Jika tidak ada ID komoditas, kembalikan 'Semua Komoditas'
        if(empty($id_komoditas)) {
            return 'Semua Komoditas';
        }
        
        $this->db->select('nama_komoditas');
        $this->db->from('komoditas');
        $this->db->where('id_komoditas', $id_komoditas);
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            return $query->row()->nama_komoditas;
        }
        
        return 'Komoditas Tidak Diketahui';
    }
}