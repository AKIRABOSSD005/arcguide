<?php
// Database connection
require_once '../config/dbcon.php';

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch count of non-admin users
$sql = "SELECT COUNT(*) AS user_count FROM users WHERE role != 'admin'";
$result = $conn->query($sql);

$usersCount = 0;
if ($result && $row = $result->fetch_assoc()) {
    $usersCount = (int)$row['user_count'];
}
