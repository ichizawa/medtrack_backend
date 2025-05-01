<?php

namespace API;

include_once __DIR__ . '/../config.php';

class Logout
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function logout($request)
    {
        session_destroy();
        $_SESSION = array();
        session_abort();

        http_response_code(200);
        echo json_encode(['status' => true, 'message' => 'Logout successful']);
        exit;
    }

}
