<?php
// ../functions/getPastEvents.php

require '../config/dbcon.php'; // Update the path if needed

$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT title, description, image, location, start_date, end_date FROM events WHERE end_date < ? ORDER BY end_date DESC LIMIT 3");
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$pastEvents = [];
while ($event = $result->fetch_assoc()) {
    $pastEvents[] = $event;
}

echo json_encode($pastEvents);

$stmt->close();
$conn->close();

