<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ob_start();
session_start();

// $servername = "sql209.infinityfree.com";
// $username = "if0_36660621";
// $password = "osZNYd9gI0g9";
// $dbname = "if0_36660621_genkicms";

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_DATABASE'];

$date = date("Y-m-d", strtotime("2024-06-12"));
$datenow = date("Y-m-d");

// if($datenow > $date){
//     $conn = die();
// }else{
//     $conn = mysqli_connect($servername, $username, $password, $dbname);

//     if (!$conn) {
//         die ("Connection failed: " . mysqli_connect_error());
//     }

// }

$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    'a1d97d939eb60c02f4e0',
    '4b4bbd3f1262a17dc0a3',
    '1982314',
    $options
);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}