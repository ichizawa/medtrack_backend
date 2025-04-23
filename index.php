<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Controllers\Users;
use Klein\Klein;
use API\Register;
use API\Login;
use Controllers\MedicalRecords;

$router = new Klein();
// Instantiate controllers
$login = new Login($conn);
$register = new Register($conn);

$medical_records = new MedicalRecords($conn);
$user = new Users($conn);

// Routes
$router->respond('POST', '/api/login', function ($request) use ($login) {
    return $login->login($request);
});

$router->respond('POST', '/api/register', function ($request) use ($register) {
    return $register->register($request);
});

// User
$router->respond('GET', '/api/get-user-details/[:id]', function ($request) use ($user) {
    return $user->index($request);
});

// Medical Records
$router->respond('GET', '/api/get-medical-records/[:id]', function ($request) use ($medical_records) {
    return $medical_records->index($request);
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
