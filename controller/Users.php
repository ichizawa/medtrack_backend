<?php

namespace Controllers;

include_once __DIR__ . '/../config.php';

use Model\User;

class Users
{
    private $user;

    public function __construct($conn)
    {
        $this->user = new User($conn);
    }

    public function index($request)
    {
        $id = $request->param('id');
        
        $result = $this->user->getUserById($id);

        http_response_code(200);
        echo json_encode([
            'data' => $result
        ]);
        exit;
    }
}

