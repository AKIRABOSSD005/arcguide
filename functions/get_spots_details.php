<?php
// get_spot_details.php
include '../config/dbcon.php';

// Force JSON response
header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$spot_id = (int) $_GET['id'];

// Prepared statement for main spot details
$stmt = $conn->prepare("
    SELECT ts.id, ts.name, ts.description, ts.address,
           ts.latitude, ts.longitude, ts.google_maps_url,
           sc.name AS category
    FROM tourist_spots ts
    LEFT JOIN spot_categories sc ON ts.category_id = sc.id
    WHERE ts.id = ?
    LIMIT 1
");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$result = $stmt->get_result();
$spot = $result->fetch_assoc();

if (!$spot) {
    echo json_encode(["error" => "Tourist spot not found"]);
    exit;
}

// Fetch general info
$general = [];
$stmt = $conn->prepare("SELECT location, significance, structure FROM spot_general_info WHERE spot_id = ? LIMIT 1");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $general = $res->fetch_assoc();
}

// Fetch FAQs
$faqs = [];
$stmt = $conn->prepare("SELECT question, answer FROM spot_faqs WHERE spot_id = ?");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $faqs[] = $row;
}

// Fetch Tips
$tips = [];
$stmt = $conn->prepare("SELECT tip FROM spot_tips WHERE spot_id = ?");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $tips[] = $row['tip'];
}

// Fetch Summary
$summary = "";
$stmt = $conn->prepare("SELECT summary FROM spot_summaries WHERE spot_id = ? LIMIT 1");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $summary = $res->fetch_assoc()['summary'];
}

echo json_encode([
    "spot" => $spot,
    "general" => $general,
    "faqs" => $faqs,
    "tips" => $tips,
    "summary" => $summary
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
