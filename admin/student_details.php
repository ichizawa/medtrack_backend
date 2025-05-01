<?php
require_once './Auth/auth_check.php';
ob_start();

include __DIR__ . '/../config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $studentId = $_GET['id'];

    // Fetch student info
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "<p>Student not found.</p>";
        exit;
    }
    $stmt->close();

    // Fetch medical records
    $recordStmt = $conn->prepare("SELECT * FROM records WHERE user_id = ?");
    $recordStmt->bind_param("i", $studentId);
    $recordStmt->execute();
    $recordsResult = $recordStmt->get_result();

    $records = [];
    if ($recordsResult->num_rows > 0) {
        while ($record = $recordsResult->fetch_assoc()) {
            $records[] = $record;
        }
    } else {
        $records = null;
    }
    $recordStmt->close();
} else {
    echo "<p>Invalid student ID.</p>";
    exit;
}
?>

<link rel="stylesheet" href="assets/css/student_details.css">

<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">Record Details</h1>
                    <p class="page-subtitle">Review full information of the selected record.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Student and Medical Records Details -->
    <div class="container mb-5">
        <div class="col-md-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body">
                    <h4 class="mb-4 text-primary fw-bold">Student Information</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Name:</strong> <?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong> <?= htmlspecialchars($student['email']) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Username:</strong> <?= htmlspecialchars($student['username']) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Student ID:</strong> <?= htmlspecialchars($student['student_id']) ?>
                        </div>
                    </div>
                </div>

                <!-- Display Medical Records -->
                <div class="px-4 pb-4">
                    <h4 class="mt-4 mb-3 text-secondary fw-semibold">Medical Records</h4>
                    <?php if ($records): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered rounded-4 overflow-hidden shadow-sm">
                                <thead class="table-primary text-center align-middle">
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Document Type</th>
                                        <th>Note</th>
                                        <th>Entry Date</th>
                                        <th>Expiration Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle text-center">
                                    <?php foreach ($records as $record): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($record['document_name']) ?></td>
                                            <td><?= htmlspecialchars($record['document_type']) ?></td>
                                            <td><?= htmlspecialchars($record['note']) ?></td>
                                            <td><?= htmlspecialchars($record['entry_date']) ?></td>
                                            <td><?= htmlspecialchars($record['exp_date']) ?></td>
                                            <td> <?= htmlspecialchars($record['status']) ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No medical records found for this student.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>