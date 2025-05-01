<?php

namespace Controllers;

include_once __DIR__ . '/../config.php';

use Exception;
use Model\Records;

class MedicalRecords
{
    private $records;
    private $pusher;

    public function __construct($conn, $pusher)
    {
        $this->records = new Records($conn);
        $this->pusher = $pusher;
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

        if (empty($records)) {
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
        $input = json_decode(file_get_contents('php://input'), true);

        $user_id = $input['user_id'];
        $record_name = $input['record_name'];
        $document_type = $input['document_type'];
        $note = $input['note'];
        $exp_date = $input['exp_date'];
        $file = $input['file'];

        if (empty($user_id) || empty($document_type) || empty($exp_date) || empty($note) || empty($record_name)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Missing required parameters'
            ]);
            exit;
        }

        if (empty($input['file'])) {
            http_response_code(400);
            echo json_encode([
                'message' => 'File is missing'
            ]);
            exit;
        }

        $filename = basename($file['name']);
        $filedata = $file['data']; // base64 string
        $filetype = $file['type'];

        $decoded = base64_decode($filedata);
        $savePath = __DIR__ . '/../assets/public/records/' . $filename;

        file_put_contents($savePath, $decoded);

        $res = $this->records->uploadRecords([
            'user_id' => $user_id,
            'document_name' => $record_name,
            'document_type' => $document_type,
            'note' => $note,
            'exp_date' => $exp_date,
            'file_name' => $filename
        ]);

        if ($res == 0) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Error uploading file, please try again'
            ]);
            exit;
        }

        if ($res == 2) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Record already exists'
            ]);
            exit;
        }

        // if($res == 1){
        //     $this->pusher->trigger('my-record', 'upload-record', $res);
        // }
        $this->pusher->trigger('my-record', 'upload-record', 'test-data');
        http_response_code(200);
        echo json_encode([
            'message' => 'Record uploaded successfully',
            // 'data' => $res
        ]);
        exit;
    }

    public function expiration($request)
    {
        $id = $request->param('id');

        if (empty($id)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID parameter is missing'
            ]);
            exit;
        }

        $result = $this->records->findExpiration($id);

        if (empty($result)) {
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

    public function specific($request)
    {
        $id = $request->param('id');
        if (empty($id)) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID parameter is missing'
            ]);
            exit;
        }

        $record = $this->records->getSpecificRecordById($id);

        if (empty($records)) {
            http_response_code(404);
            echo json_encode([
                'message' => 'No records found'
            ]);
            exit;
        }

        http_response_code(200);
        echo json_encode([
            'record' => $record
        ]);
        exit;
    }
}

