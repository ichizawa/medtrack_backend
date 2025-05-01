<?php
session_start();

// Function to redirect to login
function redirectToLogin() {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Location: ./Auth/login.php?unauthorized=true");
    exit();
}

// Check if session is valid
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    redirectToLogin();
}

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirectToLogin();
}

// Check session expiry (optional: set timeout to 30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    redirectToLogin();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Prevent caching of protected pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?> 