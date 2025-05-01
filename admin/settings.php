<?php
require_once './Auth/auth_check.php';
ob_start();
?>
<link rel="stylesheet" href="assets/css/settings.css">

<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">System Settings</h1>
                    <p class="page-subtitle">Configure system preferences and notifications</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';       
?> 