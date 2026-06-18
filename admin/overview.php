<?php
include "sidbar.php";
require ('../expenses/all_expense.php');
require_once ("users/select.php");
require_once ("../category/category.php");
$user=new User();
$users=$user->getAllUsers();
$count_user=count($users);
$category=new Category();
$categorys=$category->getAll();
$count_category=count($categorys);
// print_r(count($users));
// echo $count_user;
// exit();


$expense = new Expense();
$expenseData = $expense->getAll();
$expenseCount = count($expenseData);

?>

    <div class="main admin-main">
      <header class="topbar admin-topbar">
        <div class="topbar-title">
          <h1 class="admin-title">Admin Panel</h1>
          <p class="admin-subtitle">Manage users and expense categories locally.</p>
        </div>
      </header>

      <main class="content admin-content">
        <section class="view active" id="view-overview">
          <div class="stats-grid">
            <article class="stat-card">
              <span class="stat-label">Users</span>
              <strong class="stat-value" id=""><?=count($users)?></strong>
              <span class="stat-meta">Total added</span>
            </article>
            <article class="stat-card accent">
              <span class="stat-label">Categories</span>
              <strong class="stat-value" id=""><?=count($categorys)?></strong>
              <span class="stat-meta">Available categories</span>
            </article>
            <article class="stat-card">
              <span class="stat-label">Expenses</span>
              <strong class="stat-value" id=""><?=count($expenseData)?></strong>
              <span class="stat-meta">Total records</span>
            </article>
          </div>

          <div class="dashboard-grid">
            <article class="panel">
              <div class="panel-header">
                <h2>Quick actions</h2>
              </div>
              <div class="admin-actions">
                <a href="users.php" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Manage Users</a>
                <a href="categories.php" class="btn btn-primary"><i class="fa-solid fa-tags me-2"></i>Manage Categories</a>
                <a href="expenses.php" class="btn btn-primary"><i class="fa-solid fa-money-bill-wave me-2"></i>Manage Expenses</a>
              </div>
            </article>
          </div>
        </section>
      </main>
    </div>
  </div>

  <script>
    function updateOverviewStats() {
      const USERS_KEY = 'expenseflow_admin_users';
      const CATEGORIES_KEY = 'expenseflow_categories';
      const EXPENSES_KEY = 'expenseflow_data';

      document.getElementById('statUsers').textContent = (localStorage.getItem(USERS_KEY) ? JSON.parse(localStorage.getItem(USERS_KEY)) : []).length;
      document.getElementById('statCategories').textContent = (localStorage.getItem(CATEGORIES_KEY) ? JSON.parse(localStorage.getItem(CATEGORIES_KEY)) : []).length;
      document.getElementById('statExpenses').textContent = (localStorage.getItem(EXPENSES_KEY) ? JSON.parse(localStorage.getItem(EXPENSES_KEY)) : []).length;
    }

    document.getElementById('adminLogout').addEventListener('click', () => {
      window.location.href = '../login.php';
    });

    updateOverviewStats();
  </script>
</body>
</html>
