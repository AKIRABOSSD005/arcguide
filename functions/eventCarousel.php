<?php
require_once '../config/dbcon.php';

$events = [];

$sql = "SELECT * FROM events WHERE is_approved = 'admin' ORDER BY start_date ASC LIMIT 10";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fix image path for use in HTML
        $row['image'] = '/' . ltrim($row['image'], '/'); // /assets/events/...
        $events[] = $row;
    }
}

