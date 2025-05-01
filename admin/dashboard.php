<?php
require_once './Auth/auth_check.php';
include __DIR__ . '/../config.php';

require_once './Auth/auth_check.php';
include __DIR__ . '/../config.php';

// Query to get the total number of rows in the 'users' table (total students)
$totalStudentsStmt = $conn->prepare("SELECT COUNT(id) AS total FROM users");
$totalStudentsStmt->execute();
$totalStudentsResult = $totalStudentsStmt->get_result();
$totalStudentsData = $totalStudentsResult->fetch_assoc();
$totalStudents = $totalStudentsData['total']; // Store the total count of students
$totalStudentsStmt->close();

?>
<link rel="stylesheet" href="assets/css/dashboard.css">

<div class="container-fluid p-0">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body d-flex align-items-center">
                    <div class="welcome-text">
                        <h2 class="welcome-title">Welcome back, Admin!</h2>
                        <p class="welcome-subtitle mb-0">Medical Records Administrator</p>
                    </div>
                    <!-- <div class="welcome-icons ms-auto">
                        <img src="assets/img/doctor.png" alt="Doctor" class="welcome-doctor">
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Students -->
        <div class="col-sm-6 col-md-3">
            <a href="list_of_students.php" style="text-decoration: none; color: inherit;">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon students mb-3">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3 class="stat-number"><?= $totalStudents ?></h3> 
                        <p class="stat-label">Total Students</p>
                        <div class="stat-progress">
                            <div class="progress">
                                <div class="progress-bar" style="width: 75%"></div>
                            </div>
                            <small>Active Students</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Medical Records -->
        <div class="col-sm-6 col-md-3">
            <a href="medical_records.php" style="text-decoration: none; color: inherit;">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon records mb-3">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <h3 class="stat-number">2,450</h3>
                        <p class="stat-label">Medical Records</p>
                        <div class="stat-progress">
                            <div class="progress">
                                <div class="progress-bar bg-complete" style="width: 65%"></div>
                            </div>
                            <small>Complete Records</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pending Records -->
        <div class="col-sm-6 col-md-3">
            <a href="dashboard.php" style="text-decoration: none; color: inherit;">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon pending mb-3">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <h3 class="stat-number">128</h3>
                        <p class="stat-label">Pending</p>
                        <div class="stat-progress">
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 35%"></div>
                            </div>
                            <small>Due This Month</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Expired Records -->
        <div class="col-sm-6 col-md-3">
            <a href="dashboard.php" style="text-decoration: none; color: inherit;">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon expiring mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="stat-number">45</h3>
                        <p class="stat-label">Expired Records</p>
                        <div class="stat-progress">
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: 15%"></div>
                            </div>
                            <small>Next 30 Days</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Uploads</h5>
                    <a href="medical_records.php" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <!-- Activity Item 1 -->
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <div class="activity-details">
                                <h6>New Medical Record Added</h6>
                                <p>John Doe's vaccination records were uploaded</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="activity-item">
                            <div class="activity-icon bg-warning">
                                <i class="fas fa-syringe"></i>
                            </div>
                            <div class="activity-details">
                                <h6>Vaccination Update Required</h6>
                                <p>15 patients need to update their vaccination records</p>
                                <small class="text-muted">5 hours ago</small>
                            </div>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="activity-item">
                            <div class="activity-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-details">
                                <h6>Records Verified</h6>
                                <p>Batch verification completed for 25 patients</p>
                                <small class="text-muted">1 day ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>