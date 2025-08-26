<?php
$host = $_SERVER['HTTP_HOST'] ?? '';
$serverName = $_SERVER['SERVER_NAME'] ?? '';
$ip = $_SERVER['SERVER_ADDR'] ?? '';

if (
    strpos($host, 'localhost') === 0 ||          // matches localhost, localhost:3000, etc.
    strpos($serverName, 'localhost') === 0 ||
    $ip === '127.0.0.1' ||
    $ip === '::1'
) {
    // Local (XAMPP)
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "arcguide_db";
} else {
    // Live (Hostinger)
    $server = "localhost";
    $username = "u400182149_areacoop005";
    $password = "Te@mAre@CoopB@SCPCC2024";
    $database = "u400182149_arcguide_db";
}

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
