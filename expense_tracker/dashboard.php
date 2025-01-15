<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    
    <!-- Bootstrap CSS for styling the application -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Link to external CSS for additional custom styles -->
    <link rel="stylesheet" href="Expense_tracker.css">
    
    <!-- Bootstrap JS for adding Bootstrap functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- External JavaScript file to handle expense tracking logic -->
    <script src="Expense_tracker.js" defer></script>
</head>
<body>
    <div class="container mt-5">
         <!-- Expense Tracker Title -->
        <h1 class="text-center mb-4" id="expense-tracker">Expense Tracker</h1>

        <h1 class="text-center mb-4">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Expense Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                
                <!-- Form for adding new expenses -->
                <form id="expense-form">
                    <!-- Input field for the expense name -->
                    <div class="mb-3">
                        <label for="expense-name" class="form-label">Expense Name</label>
                        <input type="text" class="form-control" id="expense-name" placeholder="Expense" required>
                    </div>

                    <!-- Input field for the amount, must be a number -->
                    <div class="mb-3">
                        <label for="expense-amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="expense-amount" placeholder="Amount" step="0.01" required>
                    </div>

                    <!-- Dropdown for selecting the expense category -->
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

                    <!-- Input field for selecting the date of the expense -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date">
                    </div>

                    <!-- Submit button to add the expense to the list -->
                    <button id="addBtn" type="submit" class="btn w-50">Add Expense</button>
                </form>
            </div>
        </div>

        <!-- Expense Table -->
        <div class="mt-5">
            <h3 class="text-center">Expense List</h3>
            <!-- Table to display the list of expenses -->
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <!-- Table headers: Expense Name, Amount, Category, Date, and Action buttons -->
                        <th>Expense Name</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expense-list">
                    <!-- Table rows for expenses will be dynamically added here using JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Total Amount Display -->
        <div class="text-end mt-4">
            <strong>Total:</strong> $<span id="total-amount">0</span> 
            <!-- Display total amount of all expenses here -->
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
