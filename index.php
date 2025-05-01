<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// 🛡 Handle preflight OPTIONS request after setting headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/middleware/CheckAuth.php';

use Klein\Klein;

use middleware\CheckAuth;

use API\Register;
use API\Login;
use API\Logout;

use Controllers\Users;
use Controllers\MedicalRecords;
use Controllers\Dashboard;
use Controllers\Profile; 

$router = new Klein();

// Instantiate controllers
$login = new Login($conn);
$register = new Register($conn);
$logout = new Logout($conn);

$medical_records = new MedicalRecords($conn, $pusher);
$user = new Users($conn);
$dashboard = new Dashboard($conn);
$profile = new Profile($conn);

// Routes
$router->respond('GET', '/', function ($request) use ($login) {
    ob_start();
    include __DIR__ . '/404.php'; // Adjust path as needed
    return ob_get_clean();
});

$router->respond('POST', '/api/login', function ($request) use ($login) {
    return $login->login($request);
});

$router->respond('POST', '/api/register', function ($request) use ($register) {
    return $register->register($request);
});

$router->respond('POST', '/api/logout', function ($request) use ($logout) {
    return $logout->logout($request);
});

// Dashboard
$router->respond('GET', '/api/dashboard/[:id]', function ($request) use ($dashboard) {
    return $dashboard->index($request);
});

// User
$router->respond('GET', '/api/get-user-details/[:id]', function ($request) use ($user) {
    return $user->index($request);
});
// Profile
$router->respond('GET', '/api/profile/[:id]', function ($request) use ($profile) {
    return $profile->getProfile($request);
});

// Medical Records
$router->respond('GET', '/api/get-medical-records/[:id]', function ($request) use ($medical_records) {
    return $medical_records->index($request);
});

$router->respond('GET', '/api/get-specific-records/[:id]', function ($request) use ($medical_records) {
    return $medical_records->specific($request);
});

$router->respond('GET', '/api/get-expiration-record/[:id]', function ($request) use ($medical_records) {
    return $medical_records->expiration($request);
});

$router->respond('POST', '/api/add-medical-record', function ($request) use ($medical_records) {
    return $medical_records->add($request);
});

// Example dynamic user route
$router->respond('GET', '/user/[:id]', function ($request) {
    return "User ID: " . htmlspecialchars($request->id);
});

$router->dispatch();