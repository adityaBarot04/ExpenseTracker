<?php
session_start();
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

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $name = $data['name'];
    $amount = $data['amount'];
    $category = $data['category'];
    $date = $data['date'];
    $user_id = $_SESSION['user_id'];

    // Check for valid date format (YYYY-MM-DD)
    if (DateTime::createFromFormat('Y-m-d', $date) === false) {
        echo json_encode(['success' => false, 'message' => 'Invalid date format']);
        exit();
    }

    // Prepare the insert query
    $stmt = $mysqli->prepare("INSERT INTO expenses (expense_name, amount, category, expense_date, user_id) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing the statement']);
        exit();
    }

    $stmt->bind_param("sdssi", $name, $amount, $category, $date, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $expense = [
            'id' => $stmt->insert_id,
            'expense_name' => $name,
            'amount' => $amount,
            'category' => $category,
            'expense_date' => $date
        ];
        echo json_encode(['success' => true, 'expense' => $expense]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding expense']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
}

$mysqli->close();
?>
