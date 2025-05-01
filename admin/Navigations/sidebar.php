<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>MedTrack</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
            <a href="dashboard.php">
            <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="<?php echo $current_page == 'list_of_students.php' ? 'active' : ''; ?>">
            <a href="list_of_students.php">
                <i class="fas fa-user-graduate"></i>
                <span>Student Records</span>
            </a>
        </li>
        <li class="<?php echo $current_page == 'medical_records.php' ? 'active' : ''; ?>">
            <a href="medical_records.php">
                <i class="fas fa-file-medical"></i>
                <span>Medical Records</span>
            </a>
        </li>
        <li class="<?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
            <a href="reports.php">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </li>
        <li class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
            <a href="profile.php">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
        <li>
            <a href="./Auth/logout.php" class="logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</nav> 