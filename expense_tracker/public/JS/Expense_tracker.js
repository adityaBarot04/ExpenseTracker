document.addEventListener("DOMContentLoaded", () => {
    let expenseForm = document.getElementById('expense-form');
    let expenseList = document.getElementById('expense-list');
    let total = document.getElementById('total-amount');
    let filterCategory = document.getElementById('filter-category');
    let filterBtn = document.getElementById('filterBtn');

    let expenses = [];
    let editingExpenseId = null; // Track the expense being edited

    // Fetch expenses for logged-in user on page load
    fetchExpenses();

    // Handle form submission for adding or editing expenses
    expenseForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let name = document.getElementById("expense-name").value;
        let amount = parseFloat(document.getElementById("expense-amount").value);
        let category = document.getElementById("category").value;
        let date = document.getElementById("date").value;

        // Validate if the amount is positive
        if (amount < 0) {
            alert("Amount must be positive!");
            return;
        }

        let data = {
            name: name,
            amount: amount,
            category: category,
            date: date
        };

        // If editing an existing expense
        if (editingExpenseId) {
            data.id = editingExpenseId; // Add the expense ID to the data
            updateExpense(data);
        } else {
            // If adding a new expense
            addExpense(data);
        }
    });

    // Handle clicks on the expense list (edit or delete buttons)
    expenseList.addEventListener("click", (e) => {
        console.log("Button clicked:", e.target);
        const id = parseInt(e.target.dataset.id);

        if (e.target.classList.contains("delete-btn")) {
            deleteExpense(id);
        }

        if (e.target.classList.contains("edit-btn")) {
            editExpense(id);
        }
    });

    // Filter expenses based on selected category
    filterBtn.addEventListener("click", () => {
        let selectedCategory = filterCategory.value;
        if (selectedCategory) {
            let filteredExpenses = expenses.filter(expense => expense.category === selectedCategory);
            showExpenses(filteredExpenses);
            updateTotalAmount(filteredExpenses);
        } else {
            showExpenses(expenses);
            updateTotalAmount(expenses);
        }
    });

    function fetchExpenses() {
        fetch('fetch_expense.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                expenses = result.expenses; // Update the global expenses array
                showExpenses(expenses);
                updateTotalAmount(expenses);
            } else {
                alert(result.message);
            }
        });
    }

    // Show the list of expenses
    function showExpenses(expensesToShow) {
        expenseList.innerHTML = ""; // Clear the current list

        expensesToShow.forEach(expense => {
            let amount = parseFloat(expense.amount);

            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${expense.expense_name}</td>
                <td>$${amount.toFixed(2)}</td>
                <td>${expense.category}</td>
                <td>${expense.expense_date}</td>
                <td>
                    <button class="edit-btn btn btn-warning" data-id="${expense.id}">Edit</button>
                    <button class="delete-btn btn btn-danger" data-id="${expense.id}">Delete</button>
                </td>
            `;
            expenseList.appendChild(row);
        });
    }

    // Add new expense to the backend and to the local expenses array
    function addExpense(data) {
        fetch('add_expense.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                expenses.push(result.expense);
                showExpenses(expenses);
                updateTotalAmount(expenses);
                expenseForm.reset();
            } else {
                alert("Error adding expense!");
            }
        });
    }

    function updateExpense(data) {
        fetch('edit_expense.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            console.log("Server response:", result);
            if (result.success && result.expense) {
                expenses = expenses.map(expense =>
                    expense.id === editingExpenseId ? result.expense : expense
                );
    
                updateExpenseRow(result.expense);
                updateTotalAmount(expenses);
                expenseForm.reset();
                editingExpenseId = null;
            } else {
                alert("Error updating expense!");
            }
        });

    }
    
    // Delete an expense from the backend and update the local expenses array
    function deleteExpense(id) {
        fetch(`delete_expense.php?id=${id}`, { method: 'POST' })
        .then(response => response.json())
        .then(result => {
            console.log(result);
            if (result.success) {
                fetchExpenses(); 
            } else {
                alert("Error deleting expense!");
            }
        }).catch(error => {
            console.error("Error:", error);
        });
    }

    // Set the form fields with the current expense data for editing
    function editExpense(id) {
        const expense = expenses.find(expense => expense.id === id);

        if (expense) {
            document.getElementById("expense-name").value = expense.expense_name;
            document.getElementById("expense-amount").value = expense.amount;
            document.getElementById("category").value = expense.category;
            document.getElementById("date").value = expense.expense_date;

            editingExpenseId = id; // Set the editing expense ID
        }else {
            console.log("Expense not found for ID:", id);  // If expense not found
        }
    }

    // Update the row of the edited expense
    function updateExpenseRow(updatedExpense) {
        if (!updatedExpense || !updatedExpense.id) {
            console.error("Invalid expense object passed to updateExpenseRow:", updatedExpense);
            return; // Exit if the expense data is invalid
        }

        const button = expenseList.querySelector(`button[data-id="${updatedExpense.id}"]`);
        if (button) {
            const row = button.closest('tr');
            if (row) {
                row.children[0].textContent = updatedExpense.expense_name;
                row.children[1].textContent = `$${updatedExpense.amount.toFixed(2)}`;
                row.children[2].textContent = updatedExpense.category;
                row.children[3].textContent = updatedExpense.expense_date;
            }
        }
    }

    // Update the displayed total amount for a specific category or all expenses
    function updateTotalAmount(expensesToUpdate) {
        let totalAmount = expensesToUpdate.reduce((total, expense) => total + parseFloat(expense.amount), 0);
        total.textContent = totalAmount.toFixed(2);
    }
});
