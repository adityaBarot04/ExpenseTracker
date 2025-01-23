<?php
session_start();
require_once '../src/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Expense ID is required']);
    exit();
}

$expense_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Establish database connection
$mysqli = new mysqli('localhost', 'root', 'Password@80085', 'users');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the expense belongs to the logged-in user
$stmt = $mysqli->prepare("SELECT id FROM expenses WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $expense_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Expense not found or does not belong to the logged-in user']);
    exit();
}

// Delete the expense from the database
$stmt = $mysqli->prepare("DELETE FROM expenses WHERE id = ?");
$stmt->bind_param("i", $expense_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Expense deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting expense']);
}

$stmt->close();
$mysqli->close();
?>
