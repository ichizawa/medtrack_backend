<?php

namespace Controllers;

include_once __DIR__ . '/../config.php';

use Model\Records;

class MedicalRecords
{
    private $records;

    public function __construct($conn)
    {
        $this->records = new Records($conn);
    }

    public function index($request)
    {
        $id = $request->param('id');
        if (empty($id)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID parameter is missing'
            ]);
            exit;
        }

        $records = $this->records->getRecordsById($id);

        if(empty($records)) {
            http_response_code(404);
            echo json_encode([
                'message' => 'No records found'
            ]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            'records' => $records
        ]);
        exit;
    }

    public function add($request)
    {
        $user_id = $request->param('user_id');
        $document_type = $request->param('document_type');
        $note = $request->param('note');
        $entry_date = $request->param('entry_date');
        $exp_date = $request->param('exp_date');

        if(empty($user_id) || empty($document_type) || empty($entry_date) || empty($exp_date) || empty($note)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Missing required parameters'
            ]);
            exit;
        }

        if(empty($_FILES['file_name'])) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Missing file'
            ]);
            exit;
        }

        $file_name = $_FILES['file_name']['name'];

        if(!move_uploaded_file($_FILES['file_name']['tmp_name'], __DIR__ . "/../assets/public/records/" . $file_name)) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Failed to upload the file'
            ]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            'message' => 'File uploaded successfully',
        ]);
        exit;
    }

    public function expiration($request)
    {
        $id = $request->param('id');

        if(empty($id)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID parameter is missing'
            ]);
            exit;
        }

        $result = $this->records->findExpiration($id);

        if(empty($result)) {
            http_response_code(404);
            echo json_encode([
                'message' => 'No records found'
            ]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            'message' => 'Expiration Record Found',
            'records' => $result
        ]);
        exit;
    }
}

