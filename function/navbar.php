   
   <?php
   include 'connect.php';
   session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
   ?>
   
   <div class="main">
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
                <div class="topbar-title">
                    <h1 id="pageTitle">Dashboard</h1>
                    <p id="pageSubtitle">Overview of your spending</p>
                </div>
                <button class="btn btn-primary" id="quickAddBtn"><a href="expense.php?method=insert">+ Add Expense </a></button>
                <!-- <a class="btn btn-outline" href="admin.php">Admin</a> -->
                <a class="btn btn-outline" href="user/logout.php" id="logoutBtn">Logout</a>
            </header>