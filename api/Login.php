<?php

namespace API;

include_once __DIR__ . '/../config.php';

class Login
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function login($request)
    {
        // $username = $request->param('username');
        // $password = $request->param('password');
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? null;
        $password = $input['password'] ?? null;

        if (!$username || !$password) {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['status' => false, 'message' => 'Missing username or password']);
            exit;
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_object();
            if (password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                echo json_encode(['status' => true, 'message' => 'Login successful', 'user' => $user]);
                exit;
            } else {
                header('Content-Type: application/json', true, 401);
                echo json_encode(['status' => false, 'message' => 'Invalid username or password']);
                exit;
            }
        } else {
            header('Content-Type: application/json', true, 401);
            echo json_encode(['status' => false, 'message' => 'No user found! Please register']);
            exit;
        }
    }

}
