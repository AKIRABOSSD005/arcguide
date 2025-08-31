<?php
require '../config/nocache.php';
require_once(__DIR__ . '/../config/dbcon.php');

// Get visitor details
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Get visitor local time and timezone from POST, fallback to server values
$visitorDateTime = $_POST['visitorDateTime'] ?? date('Y-m-d H:i:s');
$timezone = $_POST['timezone'] ?? date_default_timezone_get();

// Extract date for unique check
$today = substr($visitorDateTime, 0, 10); // YYYY-MM-DD

// Insert or update visitor (safe from duplicates)
$stmt = $conn->prepare("
    INSERT INTO visitors (ip_address, user_agent, visit_date, created_at, timezone)
    VALUES (?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        user_agent = VALUES(user_agent), 
        created_at = VALUES(created_at),
        timezone = VALUES(timezone)
");
$stmt->bind_param("sssss", $ip, $userAgent, $today, $visitorDateTime, $timezone);
$stmt->execute();
$stmt->close();

// Fetch yearly visitor totals
$query = "
    SELECT YEAR(visit_date) AS year, COUNT(DISTINCT ip_address) AS total_visitors
    FROM visitors
    GROUP BY YEAR(visit_date)
    ORDER BY year ASC
";
$result = $conn->query($query);

$years = [];
$totals = [];

while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
    $totals[] = $row['total_visitors'];
}

// Pass data to frontend for chart
$visitorData = [
    "years" => $years,
    "totals" => $totals
];

echo "<script>var visitorChartData = " . json_encode($visitorData) . ";</script>";
