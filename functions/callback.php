<?php
require_once '../vendor/autoload.php';
session_start();

use Google\Client;
use Google\Service\Oauth2 as GoogleServiceOauth2;

// STEP 1: Google OAuth Setup
$client = new Google_Client();
$client->setClientId('278002340718-260nltculojfelvkfb8na37fp6e86b6c.apps.googleusercontent.com');
$client->setClientSecret('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');

// Determine redirect URI
$host = $_SERVER['HTTP_HOST']; // includes port if present
if (
    strpos($host, 'localhost') === 0 ||
    strpos($host, '127.0.0.1') === 0 ||
    strpos($host, '[::1]') === 0
) {
    $redirectUri = 'http://localhost:3000/functions/callback.php';
    $isLocal = true;
} else {
    $redirectUri = 'https://arcguide.bascpcc.com/functions/callback.php';
    $isLocal = false;
}
$client->setRedirectUri($redirectUri);

$client->addScope('email');
$client->addScope('profile');

// STEP 2: Get Authorization Code
if (!isset($_GET['code'])) {
    echo "No authorization code received.";
    exit;
}

// STEP 3: Fetch Access Token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if ($token === null || isset($token['error'])) {
    echo "<h3>OAuth Token Fetch Error</h3><pre>";
    var_dump($token);
    echo "</pre>";
    exit;
}
$client->setAccessToken($token);

// STEP 4: Get User Info
$oauth = new GoogleServiceOauth2($client);
$userInfo = $oauth->userinfo->get();

$email = $userInfo->email;
$name = $userInfo->name;

// STEP 5: Connect to DB
require '../config/dbcon.php';

// STEP 6: Check if user already exists
$emailEscaped = $conn->real_escape_string($email);
$query = "SELECT * FROM users WHERE email = '$emailEscaped'";
$result = $conn->query($query);

$now = date('Y-m-d H:i:s');

if ($result->num_rows === 0) {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at, loggedTime) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $password = ''; // No password for Google login
    $role = 'user';
    $stmt->bind_param("sssssss", $name, $email, $password, $role, $now, $now, $now);
    $stmt->execute();
    $userId = $stmt->insert_id; // Get auto-incremented ID of new user
    $stmt->close();
} else {
    // Existing user — get their ID and role
    $row = $result->fetch_assoc();
    $userId = $row['id'];
    $role = $row['role'];

    // Update login time
    $updateStmt = $conn->prepare("UPDATE users SET loggedTime = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $now, $email);
    $updateStmt->execute();
    $updateStmt->close();
}

// ✅ STEP 6.1: Insert into Audit Trail (LOGIN)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$auditStmt = $conn->prepare("INSERT INTO audit_trail (user_id, action, table_name, record_id, new_data, ip_address, created_at) 
                             VALUES (?, 'LOGIN', 'users', ?, ?, ?, ?)");
$newData = json_encode([
    'email' => $email,
    'name'  => $name,
    'role'  => $role ?? 'user'
]);
$auditStmt->bind_param("iisss", $userId, $userId, $newData, $ip, $now);
$auditStmt->execute();
$auditStmt->close();

$conn->close();

// STEP 7: Store session (with ID)
$_SESSION['user'] = [
    'id' => $userId,
    'email' => $email,
    'name' => $name,
    'picture' => $userInfo->picture,
    'role' => $role ?? 'user' // If new user, default role
];

// STEP 8: Redirect based on role & environment
// If admin
if ($_SESSION['user']['role'] == 'admin') {
    if ($isLocal) {
        header('Location: http://localhost:3000/pages/dashboard.php');
    } else {
        header('Location: https://arcguide.bascpcc.com/pages/dashboard.php');
    }
    exit;
}

// Otherwise normal user
if ($isLocal) {
    header('Location: http://localhost:3000/index.php');
} else {
    header('Location: https://arcguide.bascpcc.com/index.php');
}
exit;
