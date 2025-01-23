<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS/Expense_tracker.css">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript -->
    <script src="JS/Expense_tracker.js" defer></script>
</head>
<body>
    <!-- Navigation Bar with Logout -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Expense Tracker</a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Expense Tracker Title -->
        <h1 class="text-center mb-4" id="expense-tracker">Expense Tracker</h1>

        <!-- Expense Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="expense-form">
                    <div class="mb-3">
                        <label for="expense-name" class="form-label">Expense Name</label>
                        <input type="text" class="form-control" id="expense-name" placeholder="Expense" required>
                    </div>
                    <div class="mb-3">
                        <label for="expense-amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="expense-amount" placeholder="Amount" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" class="form-select" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Food">Food</option>
                            <option value="Transport">Transport</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Medical">Medical</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date">
                    </div>
                    <button id="addBtn" type="submit" class="btn w-50">Add Expense</button>
                </form>
            </div>
        </div>

        <!-- Expense Table -->
        <div class="mt-5">
            <h3 class="text-center">Expense List</h3>
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Expense Name</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expense-list">
                </tbody>
            </table>
        </div>

        <!-- Total Amount Display -->
        <div class="text-end mt-4">
            <strong>Total:</strong> $<span id="total-amount">0</span>
        </div>

        <!-- Category Filter Section -->
        <div class="mb-3">
            <label for="filter-category" class="form-label">Filter by Category</label>
            <select id="filter-category" class="form-select">
                <option value="" selected>All Categories</option>
                <option value="Food">Food</option>
                <option value="Transport">Transport</option>
                <option value="Entertainment">Entertainment</option>
                <option value="Medical">Medical</option>
                <option value="Other">Other</option>
            </select>
            <button id="filterBtn" class="btn btn-primary mt-2">Filter</button>
        </div>
    </div>
</body>
</html>
