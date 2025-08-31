<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getUserDateTime(): string {
    $tz = $_SESSION['user_timezone'] ?? 'UTC';
    
    try {
        $dt = new DateTime("now", new DateTimeZone($tz));
    } catch (Exception $e) {
        $dt = new DateTime("now", new DateTimeZone("UTC"));
    }

    return $dt->format('Y-m-d H:i:s');
}
