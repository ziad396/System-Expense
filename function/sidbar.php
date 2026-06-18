 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Track and manage your expenses easily">
    <title>ExpenseFlow | Expense Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="app">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">$</div>
                <div>
                    <strong>ExpenseFlow</strong>
                    <span>Management System</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a class="nav-item<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? ' active' : '' ?>" href="dashboard.php">
                    <span class="nav-icon">▦</span> Dashboard
                </a>
                <a class="nav-item<?= basename($_SERVER['PHP_SELF']) === 'expense.php' ? ' active' : '' ?>" href="expense.php">
                    <span class="nav-icon">☰</span> Expenses
                </a>
                <button class="nav-item" type="button" data-view="add">
                    <span class="nav-icon">+</span> <a href="expense.php?method=insert">Add Expense</a>
                </button>
            </nav>
            <div class="sidebar-footer">
                <p>Data saved locally in your browser</p>
            </div>
        </aside>