<?php
session_start();

if (!empty($_POST['visitorTimezone'])) {
    $_SESSION['user_timezone'] = $_POST['visitorTimezone'];
    echo 'Timezone saved: ' . $_SESSION['user_timezone'];
} else {
    echo 'No timezone received';
}
