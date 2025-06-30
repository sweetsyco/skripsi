<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {
    protected $table = 'pengguna';
    protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getPenggunaByEmail($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    public function verifyPassword($email, $password) {
        $user = $this->getPenggunaByEmail($email);
        if ($user && password_verify($password, $user['kata_sandi'])) {
            return $user;
        }
        return false;
    }

    public function insertPengguna($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}