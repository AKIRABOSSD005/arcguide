<?php
require '../config/nocache.php';    
session_start();
require '../config/dbcon.php';

if (isset($_SESSION['user'])) {
    $userId = (int) $_SESSION['user']['id'];
    $email  = $_SESSION['user']['email'] ?? '';
    $name   = $_SESSION['user']['name'] ?? '';
    $role   = $_SESSION['user']['role'] ?? '';
    $ip     = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

    // Use user's timezone if available
    $tz = $_SESSION['user']['timezone'] ?? 'UTC';
    $dt = new DateTime("now", new DateTimeZone($tz));
    $now = $dt->format('Y-m-d H:i:s');

    // Prepare old data JSON safely
    $oldData = json_encode([
        'email' => $email,
        'name'  => $name,
        'role'  => $role
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($oldData === false) {
        $oldData = '{}'; // fallback if JSON encoding fails
    }

    // Insert into Audit Trail (with new_data set to NULL)
    $stmt = $conn->prepare("
        INSERT INTO audit_trail 
            (user_id, action, table_name, record_id, old_data, new_data, ip_address, created_at) 
        VALUES (?, 'LOGOUT', 'users', ?, ?, NULL, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iisss", $userId, $userId, $oldData, $ip, $now);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}

// Clear session
$_SESSION = [];
session_destroy();

header("Location: ../index.php");
exit();
