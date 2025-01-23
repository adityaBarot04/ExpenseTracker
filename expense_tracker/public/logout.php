<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Destroy cookies if needed
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', '', time() - 3600, '/'); // Unset session cookie
}

// Redirect to login page
header("Location: login.html");
exit();
?>
