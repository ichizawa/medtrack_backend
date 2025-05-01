<?php

namespace Model;

use Exception;

class Records
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getRecordsById($id)
    {
        $sql = "SELECT * 
        FROM records 
        WHERE user_id = $id";
        $result = $this->conn->query($sql);

        $records = [];
        while ($row = $result->fetch_object()) {
            $records[] = $row;
        }

        return $records;
    }

    public function uploadRecords($form)
    {
        $user_id = $form['user_id'];
        $document_name = $form['document_name'];
        $document_type = $form['document_type'];
        $note = $form['note'];
        $entry_date = date('Y-m-d');
        $exp_date = date('Y-m-d', strtotime($form['exp_date']));
        $file_name = $form['file_name'];

        $checkQuery = "SELECT id FROM records WHERE document_type = ? AND is_archived != 1 AND status != 0 LIMIT 1";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $document_type);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            return 2;
        }
        $checkStmt->close();

        $query = "INSERT INTO records (user_id, document_name, document_type, note, entry_date, exp_date, file_name, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sssssss", $user_id, $document_name, $document_type, $note, $entry_date, $exp_date, $file_name);

        if ($stmt->execute()) {
            $stmt->close();

            return 1;
        } else {
            $error = $stmt->error;
            $stmt->close();
            return 0;
        }
    }

    public function findExpiration($id)
    {
        $stmt = $this->conn->prepare("SELECT *, DATEDIFF(exp_date, CURDATE()) AS expires_in 
        FROM records 
        WHERE user_id = ? AND exp_date < DATE_ADD(CURDATE(), INTERVAL 1 WEEK)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $records = [];
        while ($row = $result->fetch_object()) {
            $row->expires_in = (int) $row->expires_in;
            $records[] = $row;
        }

        $stmt->close();

        return $records;
    }

    public function getSpecificRecordById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM records WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }

    public function getDashboard($id)
    {
        $completed = "SELECT COUNT(*) AS completed FROM records WHERE user_id = $id AND is_archived = 0 AND CURDATE() < exp_date";
        $result1 = $this->conn->query($completed);

        $expired = "SELECT COUNT(*) AS expired FROM records WHERE user_id = $id AND is_archived = 0 AND CURDATE() > exp_date";
        $result2 = $this->conn->query($expired);

        $total = "SELECT COUNT(*) AS total FROM records WHERE user_id = $id";
        $result3 = $this->conn->query($total);

        $documentTypes = [
            "Flu Vaccine",
            "Pneumococcal Vaccine",
            "Hepatitis B Vaccine",
            "Covid-19 Vaccine",
            "X-Ray Result",
            "CBC Result",
            "Urine Test",
            "Fecal Test",
            "Stool Series",
            "Medical Certificate",
        ];

        $result = $this->conn->query("SELECT document_type FROM records WHERE user_id = $id AND is_archived = 0 AND CURDATE() < exp_date AND document_type IN ('" . implode("','", $documentTypes) . "')");
        $found = array_column($result->fetch_all(MYSQLI_ASSOC), 'document_type');
        $pendingCount = count(array_diff($documentTypes, $found));

        return [
            'completed' => $result1->fetch_object()->completed,
            'expired' => $result2->fetch_object()->expired,
            'total' => $result3->fetch_object()->total,
            'pending' => (string) $pendingCount
        ];
    }
}
?>