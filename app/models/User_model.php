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
        // This is a simple implementation that returns a static value
        // In a real application, you would query the database
        return 'John Doe';
    }

}