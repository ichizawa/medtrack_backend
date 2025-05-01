<?php

namespace Controllers;

include_once __DIR__ . '/../config.php';

use Model\Records;

class Dashboard
{
    private $records;

    public function __construct($conn)
    {
        $this->records = new Records($conn);
    }

    public function index($request)
    {
        $id = $request->param('id');
        
        $result = $this->records->getDashboard($id);

        if(empty($result)) {
            http_response_code(404);
            echo json_encode([
                'message' => 'No records found'
            ]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            'data' => $result
        ]);
        exit;
    }
}

