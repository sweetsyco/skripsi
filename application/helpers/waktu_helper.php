
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('waktu_lalu')) {
    function waktu_lalu($datetime) {
        $now = time();
        $timestamp = strtotime($datetime);
        $diff = $now - $timestamp;
        
        if ($diff < 60) {
            return 'baru saja';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' menit yang lalu';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' jam yang lalu';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' hari yang lalu';
        } else {
            return date('d M Y', $timestamp);
        }
    }
    if (!function_exists('format_tanggal_indonesia')) {
    function format_tanggal_indonesia($datetime) {
        // Array nama hari
        $hari = array(
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        );
        
        // Array nama bulan
        $bulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        
        // Ubah string ke timestamp
        $timestamp = strtotime($datetime);
        
        // Ambil komponen tanggal
        $hari_num = date('N', $timestamp); // 1 (Senin) - 7 (Minggu)
        $tanggal = date('j', $timestamp);  // Tanggal tanpa leading zero
        $bulan_num = date('n', $timestamp); // 1-12
        $tahun = date('Y', $timestamp);
        $waktu = date('H:i', $timestamp);
        
        // Format akhir
        return $hari[$hari_num] . ', ' . $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun . ', ' . $waktu;
    }

    if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        try {
            // Cek jika input adalah timestamp
            if (is_numeric($datetime)) {
                $timestamp = (int)$datetime;
                // Validasi range timestamp (antara 1970-2038)
                if ($timestamp < 0 || $timestamp > 2147483647) {
                    return date('d M H:i', $timestamp);
                }
                $date = new DateTime();
                $date->setTimestamp($timestamp);
            } 
            // Cek jika input adalah string tanggal
            else if (is_string($datetime)) {
                $date = new DateTime($datetime);
            } 
            // Format tidak dikenali
            else {
                return 'waktu tidak valid';
            }
            
            $now = new DateTime();
            $diff = $now->diff($date);

            if ($diff->d < 1) {
                if ($diff->h < 1) {
                    if ($diff->i < 1) return 'baru saja';
                    return $diff->i . ' menit lalu';
                }
                return $diff->h . ' jam lalu';
            }
            
            return $date->format('d M H:i');
        } catch (Exception $e) {
            log_message('error', 'Error time_elapsed_string: ' . $e->getMessage());
            return 'waktu tidak valid';
        }
    }
}
    }
}