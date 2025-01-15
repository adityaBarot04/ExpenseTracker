<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $expenseId = $input['id'];
    $name = $input['name'];
    $amount = $input['amount'];
    $category = $input['category'];
    $date = $input['date'];

    $stmt = $conn->prepare("UPDATE expenses SET expense_name = ?, amount = ?, category = ?, expense_date = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sdssii", $name, $amount, $category, $date, $expenseId, $user_id);

    if ($stmt->execute()) {
        $updatedExpense = [
            'id' => $expenseId,
            'expense_name' => $name,
            'amount' => $amount,
            'category' => $category,
            'expense_date' => $date
        ];

        echo json_encode(['success' => true, 'expense' => $updatedExpense]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating expense']);
    }
    $stmt->close();
}
$conn->close();
?>
