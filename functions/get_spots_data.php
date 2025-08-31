<?php
require_once '../config/dbcon.php';

// Query spots grouped by category
$query = "
    SELECT c.name AS category_name, COUNT(s.id) AS total_spots
    FROM spot_categories c
    LEFT JOIN tourist_spots s ON c.id = s.category_id
    GROUP BY c.id, c.name
";

$result = $conn->query($query);

$labels = [];
$counts = [];
$totalSpots = 0;

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['category_name'];
        $counts[] = (int)$row['total_spots'];
        $totalSpots += (int)$row['total_spots'];
    }
} else {
    die("❌ Query Error: " . $conn->error);
}

// Prepare array for frontend (Chart.js)
$spotsByCategory = [
    "labels" => $labels,
    "counts" => $counts,
    "total"  => $totalSpots
];

echo "<script>var spotsByCategory = " . json_encode($spotsByCategory) . ";</script>";

