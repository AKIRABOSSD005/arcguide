<?php
require_once '../vendor/autoload.php';
session_start();

use Google\Client;
use Google\Service\Oauth2 as GoogleServiceOauth2;

// =====================
// STEP 1: Google OAuth Setup
// =====================
$client = new Google_Client();
$client->setClientId('278002340718-260nltculojfelvkfb8na37fp6e86b6c.apps.googleusercontent.com');
$client->setClientSecret('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');

$host = $_SERVER['HTTP_HOST']; 
if (strpos($host, 'localhost') === 0 || strpos($host, '127.0.0.1') === 0 || strpos($host, '[::1]') === 0) {
    $redirectUri = 'http://localhost:3000/functions/callback.php';
    $isLocal = true;
} else {
    $redirectUri = 'https://arcguide.bascpcc.com/functions/callback.php';
    $isLocal = false;
}
$client->setRedirectUri($redirectUri);

$client->addScope('email');
$client->addScope('profile');

// =====================
// STEP 2: Get Authorization Code
// =====================
if (!isset($_GET['code'])) {
    echo "No authorization code received.";
    exit;
}

// =====================
// STEP 3: Fetch Access Token
// =====================
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if ($token === null || isset($token['error'])) {
    echo "<h3>OAuth Token Fetch Error</h3><pre>";
    var_dump($token);
    echo "</pre>";
    exit;
}
$client->setAccessToken($token);

// =====================
// STEP 4: Get User Info
// =====================
$oauth = new GoogleServiceOauth2($client);
$userInfo = $oauth->userinfo->get();

$email = $userInfo->email;
$name  = $userInfo->name;

// =====================
// STEP 5: Connect to DB + Timezone helper
// =====================
require '../config/dbcon.php';
require_once '../functions/timezone_helper.php';

// Get actual timezone from session
$now = getUserDateTime(); 
$tz  = $_SESSION['user_timezone'] ?? 'UTC'; // actual browser timezone

// =====================
// STEP 6: User check & insert/update
// =====================
$emailEscaped = $conn->real_escape_string($email);
$query = "SELECT * FROM users WHERE email = '$emailEscaped'";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at, loggedTime, timezone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $password = ''; 
    $role = 'user';
    $stmt->bind_param("ssssssss", $name, $email, $password, $role, $now, $now, $now, $tz);
    $stmt->execute();
    $userId = $stmt->insert_id;
    $stmt->close();
} else {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
    $role   = $row['role'];

    $updateStmt = $conn->prepare("UPDATE users SET loggedTime = ?, timezone = ? WHERE email = ?");
    $updateStmt->bind_param("sss", $now, $tz, $email);
    $updateStmt->execute();
    $updateStmt->close();
}

// =====================
// STEP 7: Audit Trail
// =====================
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$newData = json_encode([
    'email' => $email,
    'name'  => $name,
    'role'  => $role ?? 'user',
    'tz'    => $tz
]);
$auditStmt = $conn->prepare("INSERT INTO audit_trail 
    (user_id, action, table_name, record_id, new_data, ip_address, created_at) 
    VALUES (?, 'LOGIN', 'users', ?, ?, ?, ?)");
$auditStmt->bind_param("iisss", $userId, $userId, $newData, $ip, $now);
$auditStmt->execute();
$auditStmt->close();

$conn->close();

// =====================
// STEP 8: Store session & redirect
// =====================
$_SESSION['user'] = [
    'id'    => $userId,
    'email' => $email,
    'name'  => $name,
    'picture' => $userInfo->picture,
    'role'  => $role ?? 'user',
    'timezone' => $tz
];

if ($_SESSION['user']['role'] == 'admin') {
    header('Location: ' . ($isLocal ? 'http://localhost:3000/pages/dashboard.php' : 'https://arcguide.bascpcc.com/pages/dashboard.php'));
} else {
    header('Location: ' . ($isLocal ? 'http://localhost:3000/index.php' : 'https://arcguide.bascpcc.com/index.php'));
}
exit;
