<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_random_color')) {
    function get_random_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}