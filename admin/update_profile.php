<?php
session_start();
require_once '../conf.php';

$fname = $_POST['firstName'];
$lname = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$userId = $_SESSION['user_id'];

$query = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', phone = '$phone' WHERE id = $userId";
if ($conn->query($query) === TRUE) {
   header("Location: profile.php");
} else {
    header("Location: profile.php");
}