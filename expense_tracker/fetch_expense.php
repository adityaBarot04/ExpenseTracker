<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$host = 'localhost';
$user = 'root';
$pass = 'Password@80085';
$dbname = 'users'; 
$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch the user's expenses
$stmt = $mysqli->prepare("SELECT id, expense_name, amount, category, expense_date FROM expenses WHERE user_id = ? ORDER BY expense_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$expenses = [];
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

echo json_encode(['success' => true, 'expenses' => $expenses]);

$stmt->close();
$mysqli->close();
?>
