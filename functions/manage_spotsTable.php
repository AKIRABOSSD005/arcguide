<?php
// fetch_spots.php

include '../config/dbcon.php';

// --- PAGINATION SETTINGS ---
$limit = 5; // rows per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// --- SEARCH & FILTER ---
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$filter = isset($_GET['filter']) ? $_GET['filter'] : ""; // 👈 new filter param

// Build WHERE clause
$where = "";
if (!empty($search)) {
    $searchEscaped = $conn->real_escape_string($search);

    switch ($filter) {
        case "name":
            $where = "WHERE ts.name LIKE '%$searchEscaped%'";
            break;
        case "description":
            $where = "WHERE ts.description LIKE '%$searchEscaped%'";
            break;
        case "address":
            $where = "WHERE ts.address LIKE '%$searchEscaped%'";
            break;
        case "category":
            $where = "WHERE sc.name LIKE '%$searchEscaped%'";
            break;
        default: // Search across multiple fields
            $where = "WHERE ts.name LIKE '%$searchEscaped%' 
                      OR ts.description LIKE '%$searchEscaped%' 
                      OR ts.address LIKE '%$searchEscaped%' 
                      OR sc.name LIKE '%$searchEscaped%'";
    }
}

// --- Count total records ---
$countSql = "SELECT COUNT(*) AS total 
             FROM tourist_spots ts 
             LEFT JOIN spot_categories sc ON ts.category_id = sc.id 
             $where";
$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// --- Fetch records with limit + offset ---
$sql = "SELECT ts.id, ts.name, ts.description, ts.address, 
               ts.latitude, ts.longitude, ts.google_maps_url, 
               ts.created_at, ts.updated_at, 
               sc.name AS category,
               COALESCE(AVG(sr.rating), 0) AS avg_rating,
               COUNT(sr.id) AS total_reviews,
               (SELECT mg.file_path 
                FROM media_gallery mg 
                WHERE mg.spot_id = ts.id 
                ORDER BY mg.created_at ASC LIMIT 1) AS image
        FROM tourist_spots ts
        LEFT JOIN spot_categories sc ON ts.category_id = sc.id
        LEFT JOIN spot_reviews sr ON ts.id = sr.spot_id
        $where
        GROUP BY ts.id
        ORDER BY ts.id ASC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$spots = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spots[] = $row;
    }
}

