<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_random_color')) {
    function get_random_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('generate_color')) {
    function generate_color($string) {
        $colors = [
            '#d342ab', // Merah muda
            '#79d22b', // Hijau
            '#2b9fd2', // Biru
            '#d28f2b', // Oranye
            '#7a2bd2', // Ungu
            '#d22b2b', // Merah
            '#2bd2a9', // Cyan
            '#d2c52b'  // Kuning
        ];
        
        $hash = crc32($string);
        return $colors[abs($hash) % count($colors)];
    }
}