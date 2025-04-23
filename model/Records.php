<?php

namespace Model;

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
            $row->expires_in = (int)$row->expires_in;
            $records[] = $row;
        }

        $stmt->close();

        return $records;
    }
}
?>