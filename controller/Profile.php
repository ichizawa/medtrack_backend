<?php

namespace Controllers;

class Profile
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getProfile($request)
    {
        $userId = $request->id;

        $stmt = $this->conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");

        if ($stmt === false) {
            return json_encode([
                "status" => "error",
                "message" => "Failed to prepare query: " . $this->conn->error
            ]);
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($user = $result->fetch_assoc()) {
                return json_encode([
                    "status" => "success",
                    "data" => $user
                ]);
            } else {
                return json_encode([
                    "status" => "error",
                    "message" => "User not found"
                ]);
            }
        } else {
            return json_encode([
                "status" => "error",
                "message" => "Query execution failed"
            ]);
        }
    }
}
