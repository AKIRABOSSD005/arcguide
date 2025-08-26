<?php
// ../functions/events_submit.php
// Always start the session first
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // User is not logged in; redirect to login page
    header("Location: ../pages/loginPage.php");
    exit();
}

include '../config/dbcon.php'; // adjust path as needed

if (isset($_POST['submitEvent'])) {
    // Sanitize input
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $start_date = mysqli_real_escape_string($conn, string: trim($_POST['start_date']));
    $end_date = mysqli_real_escape_string($conn, trim($_POST['end_date']));
    $location = mysqli_real_escape_string($conn, trim($_POST['location']));
    $category_id = intval($_POST['category_id']);
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    // Handle image upload
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

    // Insert into database
    $sql = "INSERT INTO events (title, description, start_date, end_date, location, image, category_id, is_approved, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, 1, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $title, $description, $start_date, $end_date, $location, $image_path, $category_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/events.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
