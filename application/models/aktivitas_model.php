<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_recent_activities($id_distributor) {
        $activities = [];

        // 1. Ambil permintaan terbaru
        $this->db->select('permintaan.*, komoditas.nama_komoditas, komoditas.satuan');
        $this->db->from('permintaan');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->order_by('dibuat_pada', 'DESC');
        $this->db->limit(5);
        $requests = $this->db->get()->result();

        foreach ($requests as $request) {
            $activities[] = [
                'type' => 'permintaan',
                'icon' => 'clipboard-list',
                'color' => 'text-info',
                'message' => "Permintaan baru untuk {$request->nama_komoditas} sejumlah {$request->jumlah} {$request->satuan}",
                'time' => $request->dibuat_pada
            ];
        }

        // 2. Ambil penawaran terbaru
        $this->db->select('penawaran.*, permintaan.id_distributor, pengguna.nama as nama_petani, komoditas.nama_komoditas, komoditas.satuan');
        $this->db->from('penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('petani', 'petani.id_petani = penawaran.id_petani');
        $this->db->join('pengguna', 'pengguna.id_pengguna = petani.id_pengguna');
        $this->db->join('komoditas', 'komoditas.id_komoditas = permintaan.id_komoditas');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->order_by('penawaran.dibuat_pada', 'DESC');
        $this->db->limit(5);
        $offers = $this->db->get()->result();

        foreach ($offers as $offer) {
            $status = $offer->status == 'pending' ? 'baru' : $offer->status;
            $activities[] = [
                'type' => 'penawaran',
                'icon' => 'handshake',
                'color' => $offer->status == 'accepted' ? 'text-success' : ($offer->status == 'rejected' ? 'text-danger' : 'text-warning'),
                'message' => "Penawaran {$status} dari {$offer->nama_petani} untuk {$offer->nama_komoditas} sejumlah {$offer->jumlah} {$offer->satuan}",
                'time' => $offer->dibuat_pada
            ];
        }

        // 3. Ambil penugasan terbaru
        $this->db->select('penugasan.*, pengguna.nama as nama_kurir, penawaran.id_permintaan');
        $this->db->from('penugasan');
        $this->db->join('penawaran', 'penawaran.id_penawaran = penugasan.id_penawaran');
        $this->db->join('permintaan', 'permintaan.id_permintaan = penawaran.id_permintaan');
        $this->db->join('kurir', 'kurir.id_kurir = penugasan.id_kurir');
        $this->db->join('pengguna', 'pengguna.id_pengguna = kurir.id_pengguna');
        $this->db->where('permintaan.id_distributor', $id_distributor);
        $this->db->order_by('penugasan.ditugaskan_pada', 'DESC');
        $this->db->limit(5);
        $assignments = $this->db->get()->result();

        foreach ($assignments as $assignment) {
            $statusText = $assignment->status == 'pending' ? 'dibuat' : $assignment->status;
            $activities[] = [
                'type' => 'penugasan',
                'icon' => 'truck',
                'color' => $assignment->status == 'approved' ? 'text-success' : ($assignment->status == 'rejected' ? 'text-danger' : 'text-warning'),
                'message' => "Penugasan {$statusText} untuk verifikasi oleh {$assignment->nama_kurir}",
                'time' => $assignment->ditugaskan_pada
            ];
        }

        // Urutkan berdasarkan waktu terbaru
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        // Ambil hanya 5 terbaru
        return array_slice($activities, 0, 5);
    }
    public function tambah_aktivitas($id_pengguna, $id_distributor, $jenis, $pesan) {
        $data = [
            'id_pengguna' => $id_pengguna,
            'id_distributor' => $id_distributor,
            'jenis' => $jenis,
            'pesan' => $pesan,
            'waktu' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('aktivitas', $data);
        return $this->db->insert_id();
    }
}