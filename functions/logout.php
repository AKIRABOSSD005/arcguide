<?php
session_start();
require '../config/dbcon.php'; // ✅ connect to DB for audit trail

if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id'];
    $email  = $_SESSION['user']['email'];
    $name   = $_SESSION['user']['name'];
    $role   = $_SESSION['user']['role'];
    $ip     = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $now    = date('Y-m-d H:i:s');

    // Insert into Audit Trail
    $stmt = $conn->prepare("INSERT INTO audit_trail (user_id, action, table_name, record_id, old_data, ip_address, created_at) 
                            VALUES (?, 'LOGOUT', 'users', ?, ?, ?, ?)");
    $oldData = json_encode([
        'email' => $email,
        'name'  => $name,
        'role'  => $role
    ]);
    $stmt->bind_param("iisss", $userId, $userId, $oldData, $ip, $now);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// ✅ Clear session after logging
$_SESSION = [];
session_destroy();

header("Location: ../index.php");
exit();
