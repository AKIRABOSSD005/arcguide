<?php
// Database connection
require_once '../config/dbcon.php';
// Check for connection error
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch spots from the database
$result = $conn->query("SELECT name, description, image, address FROM tourist_spots");

// Create $spots array for HTML use
$spots = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $spots[] = [
      'title' => $row['name'],
      'description' => $row['description'],
      'image' => $row['image'],
      'location' => $row['address']
    ];
  }
}



