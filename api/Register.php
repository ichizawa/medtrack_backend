<?php

namespace API;

include_once __DIR__ . '/../config.php';

class Register
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($request)
    {
        $required = ['first_name', 'last_name', 'student_id', 'email', 'username', 'password'];

        foreach ($required as $field) {
            if (empty($request->param($field))) {
                header('Content-Type: application/json', true, 400);
                echo json_encode(['status' => false, 'message' => "Missing $field"]);
                exit;
            }
        }

        $firstName = $request->param('first_name');
        $lastName = $request->param('last_name');
        $studentId = $request->param('student_id');
        $email = $request->param('email');
        $username = $request->param('username');
        $password = password_hash($request->param('password'), PASSWORD_DEFAULT);

        $query = "SELECT username FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['status' => false, 'message' => 'Username is taken']);
            exit;
        }

        $query = "INSERT INTO users (first_name, last_name, student_id, email, username, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'ssssss',
            $firstName,
            $lastName,
            $studentId,
            $email,
            $username,
            $password
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('Content-Type: application/json', true, 201);
            echo json_encode(['status' => true, 'message' => 'Registration successful']);
            exit;
        } else {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['status' => false, 'message' => 'Registration failed']);
            exit;
        }
    }

}
