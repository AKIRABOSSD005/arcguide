<?php
require_once '../config/dbcon.php';

$events = [];

$sql = "SELECT title, start_date AS start, end_date AS end FROM events WHERE is_approved = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => $row['title'],
            'start' => $row['start'],
            'end'   => $row['end']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($events);
?>
