<?php

class User_model {
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUser()
    {
        $this->db->query("SELECT name FROM " . $this->table . " LIMIT 1");
        $result = $this->db->single();
        return $result ? $result['name'] : '';
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}