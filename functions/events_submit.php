<?php
require '../config/nocache.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../pages/loginPage.php");
    exit();
}

include '../config/dbcon.php';
if (isset($_POST['submitEvent'])) {
    $title       = mysqli_real_escape_string($conn, trim($_POST['title']));
    $start_date  = mysqli_real_escape_string($conn, trim($_POST['start_date']));
    $end_date    = mysqli_real_escape_string($conn, trim($_POST['end_date']));
    $location    = mysqli_real_escape_string($conn, trim($_POST['location']));
    $category_id = intval($_POST['category_id']);
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    // Handle uploaded image
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['image']['name']);
        $target_dir = "../assets/events/";
        $unique_name = uniqid() . "_" . $img_name;
        $target_file = $target_dir . $unique_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = "assets/events/" . $unique_name;
        }
    }

    // ✅ Use visitor's local datetime from the form
    $visitorDateTime = $_POST['visitorDateTime'] ?? null;
    $createdAt = $visitorDateTime ?: date('Y-m-d H:i:s'); // fallback to server time

    $created_by = $_SESSION['user']['id'];

    // Insert into events
    $sql = "INSERT INTO events 
        (title, description, start_date, end_date, location, image, category_id, is_approved, created_by, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NULL, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssiis",
        $title, $description, $start_date, $end_date,
        $location, $image_path, $category_id, $created_by, $createdAt
    );

    if (mysqli_stmt_execute($stmt)) {
        $eventId = mysqli_insert_id($conn);

        // Insert into audit trail
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $newData = json_encode([
            'title'       => $title,
            'description' => $description,
            'start_date'  => $start_date,
            'end_date'    => $end_date,
            'location'    => $location,
            'category_id' => $category_id,
            'image'       => $image_path
        ]);

        $auditSql = "INSERT INTO audit_trail 
            (user_id, action, table_name, record_id, new_data, ip_address, created_at) 
            VALUES (?, 'INSERT', 'events', ?, ?, ?, ?)";
        $auditStmt = $conn->prepare($auditSql);
        $auditStmt->bind_param("iisss", $created_by, $eventId, $newData, $ip, $createdAt);
        $auditStmt->execute();
        $auditStmt->close();
    $_SESSION['flash_message'] = "Event submitted successfully!";

        header("Location: ../pages/events.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    $conn->close();
}