<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class User extends BaseModel
{
    public function save($data) {
        $sql = "INSERT INTO users 
                (first_name, last_name, email, password)
                VALUES 
                (:first_name, :last_name, :email, :password_hash)";
        
        $statement = $this->db->prepare($sql);
        $password_hash = $this->hashPassword($data['password']);
    
        $statement->execute([
            'first_name' => $data['first_name'],  // Use the correct key from the form
            'last_name' => $data['last_name'],    // Use the correct key from the form
            'email' => $data['email'],
            'password_hash' => $password_hash
        ]);
    
        return $this->db->lastInsertId();
    }

    public function getUserID($email) {
        $sql = "SELECT id, first_name FROM users WHERE email = :email";
        $statement = $this->db->prepare($sql);
        $statement->execute(['email' => $email]);
    
        return $statement->fetchColumn();
    }


    protected function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyAccess($email, $password)
    {
        $sql = "SELECT password FROM users WHERE email = :email";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'email' => $email
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }

        return password_verify($password, $result['password']);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}