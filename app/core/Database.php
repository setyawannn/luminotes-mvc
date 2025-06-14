<?php

class Model {
    protected $db; 

    public function __construct() {
        $host = DB_HOST; 
        $user = DB_USER;
        $pass = DB_PASS;
        $db_name = DB_NAME; 

        $this->db = new mysqli($host, $user, $pass, $db_name);
        
        if ($this->db->connect_error) {
            error_log("Koneksi Database Gagal: (" . $this->db->connect_errno . ") " . $this->db->connect_error);
            die("Koneksi Database Gagal. Silakan coba beberapa saat lagi.");
        }

        if (!$this->db->set_charset("utf8mb4")) {
            error_log("Error saat mengatur character set utf8mb4: " . $this->db->error);
        }
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}