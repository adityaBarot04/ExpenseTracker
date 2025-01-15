<?php
$servername = "localhost";
$username = "root";  // Your database username
$password = "Password@80085";      // Your database password
$dbname = "users";   // Database name updated to "users"

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
