<?php

class Note_model {
    private $db;
    private $table = 'notes';

    public function __construct() {
        $this->db = new Database;   
    }

    public function getAllNote() {
        
    }
}