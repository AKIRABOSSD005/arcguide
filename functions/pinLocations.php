<?php
require_once '../config/dbcon.php';
$result = $conn->query("SELECT name, description, image, address, latitude, longitude FROM tourist_spots");

$spots = [];
while ($row = $result->fetch_assoc()) {
  $spots[] = [
    'title' => $row['name'],
    'description' => $row['description'],
    'image' => $row['image'], // e.g. "assets/pictures/spot.svg"
    'location' => $row['address'],
    'position' => [
      'lat' => floatval($row['latitude']),
      'lng' => floatval($row['longitude'])
    ]
  ];
}


