<?php

namespace Model;

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * 
        FROM users 
        WHERE deleted_at IS NULL AND is_admin != 1";
        $result = $this->conn->query($sql);

        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserById($id)
    {
        $sql = "SELECT * 
        FROM users 
        WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }

    public function login($email, $password)
    {
        $sql = "SELECT * 
        FROM users 
        WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();
        if (password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }
}
?>