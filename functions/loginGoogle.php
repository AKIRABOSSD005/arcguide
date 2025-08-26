<?php
require_once '../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('278002340718-260nltculojfelvkfb8na37fp6e86b6c.apps.googleusercontent.com');
$client->setClientSecret('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');
// $client->setRedirectUri('https://arcguide.bascpcc.com/functions/callback.php');
if (
    strpos($_SERVER['HTTP_HOST'], 'localhost') === 0 ||
    strpos($_SERVER['SERVER_NAME'], 'localhost') === 0 ||
    $_SERVER['SERVER_ADDR'] === '127.0.0.1' ||
    $_SERVER['SERVER_ADDR'] === '::1'
) {
    $redirectUri = 'http://localhost/arcguide/functions/callback.php';
} else {
    $redirectUri = 'https://arcguide.bascpcc.com/functions/callback.php';
}
$client->setRedirectUri($redirectUri);

$client->addScope('email');
$client->addScope('profile');

$login_url = $client->createAuthUrl();
return $login_url;
