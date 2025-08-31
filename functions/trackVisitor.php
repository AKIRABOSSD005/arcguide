<?php
require_once 'config/dbcon.php';

// Get visitor details
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$today = date('Y-m-d');

// Check if already logged today (to avoid duplicate multiple logs per refresh)
$stmt = $conn->prepare("SELECT id FROM visitors WHERE ip_address = ? AND visit_date = ?");
$stmt->bind_param("ss", $ip, $today);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Insert new record
    $stmt = $conn->prepare("INSERT INTO visitors (ip_address, user_agent, visit_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ip, $userAgent, $today);
    $stmt->execute();
}

$stmt->close();


$query = "SELECT YEAR(visit_date) AS year, COUNT(DISTINCT ip_address) AS total_visitors
          FROM visitors
          GROUP BY YEAR(visit_date)
          ORDER BY year ASC";

$result = $conn->query($query);

$years = [];
$totals = [];

while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
    $totals[] = $row['total_visitors'];
}
