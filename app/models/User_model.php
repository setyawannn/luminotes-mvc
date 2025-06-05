<?php

class User_model extends Model { 
    public function getUserByEmail($email)
    {
        $escapedEmail = $this->db->real_escape_string($email);
        
        $sql = "SELECT * FROM users WHERE email = '$escapedEmail'";
        
        $result = $this->db->query($sql);
        
       
        $rows = $result->fetch_all(MYSQLI_ASSOC); 
        
        return $rows[0] ?? false; 
    }

    public function createUser($data)
    {
        $name = $this->db->real_escape_string($data['name']);
        $email = $this->db->real_escape_string($data['email']);
        $password = $this->db->real_escape_string($data['password']);
        
        $desc = "NULL";
        if (isset($data['description']) && $data['description'] !== null) {
            $escapedDescription = $this->db->real_escape_string($data['description']);
            $desc = "'$escapedDescription'";
        }
        
        $role = 'user'; 

        $sql = "INSERT INTO users (name, email, password, description, role) 
                VALUES ('$name', '$email', '$password', $desc, '$role')";
        return $this->db->query($sql);
    }

}