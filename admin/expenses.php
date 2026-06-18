<?php
include "sidbar.php";
require ('../expenses/all_expense.php');
require ('../category/category.php');
require ('users/select.php');
$category = new Category();
$users=new User();

$expense  = new Expense();
$expenseData=$expense->getAll();
?>

    <div class="main admin-main">
      <header class="topbar admin-topbar">
        <div class="topbar-title">
          <h1 class="admin-title">Expenses</h1>
          <p class="admin-subtitle">Manage expense entries across the app.</p>
        </div>
      </header>

      <main class="content admin-content">
        <section class="view active" id="view-expenses">
            <?php
            if (isset($_GET['method']) && $_GET['method']==='update') {
                # code...
                include "expenses/update.php";
                exit();
            }

            ?>
      

          <article class="panel mt-4">
            <h2>Expense List</h2>
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Amount</th>
                  <th>Created By</th>
                  <th>Email</th>
                  <th>Date</th>
                  <th>Actions</th>

                </tr>
              </thead>
              <tbody id="adminExpenseTable">
                 <?php

                        foreach($expenseData as $data)
                        {
                            ?>

                            <tr>

                                <td><?= $data['id'] ?></td>

                                <td><?= $data['title'] ?></td>

                                <td>
                                    <?= $category->getById($data['id_category'])['name'] ?>
                                </td>

                                <td><?= $data['amount'] ?></td>
                                <td><?=$users->getById($data['id_user'])['name']?></td>
                                <td><?=$users->getById($data['id_user'])['email']?></td>
                                <td>
                                    <?= date('Y-m-d', strtotime($data['date'])) ?>
                                </td>

                                <td>

                                    <a
                                        href="?method=update&id=<?= $data['id'] ?>"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Update
                                    </a>

                                    <a
                                        href="expenses/delete.php?id=<?= $data['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')"
                                    >
                                        Delete
                                    </a>

                                </td>

                            </tr>

                            <?php
                        }

                        ?>

              </tbody>
            </table>
             
          </article>
        </section>
      </main>
    </div>
  </div>

  <script>
    const EXPENSES_KEY = 'expenseflow_data';
    const CATEGORIES_KEY = 'expenseflow_categories';

    let adminEditingExpenseId = null;

    const expenseTitleInput = document.getElementById('expenseTitle');
    const expenseAmountInput = document.getElementById('expenseAmount');
    const expenseCategorySelect = document.getElementById('expenseCategory');
    const expenseDateInput = document.getElementById('expenseDate');
    const saveExpenseBtn = document.getElementById('saveExpenseBtn');
    const cancelExpenseEditBtn = document.getElementById('cancelExpenseEdit');
    const adminExpenseTable = document.getElementById('adminExpenseTable');

    function loadExpenses() {
      try {
        const data = localStorage.getItem(EXPENSES_KEY);
        return data ? JSON.parse(data) : [];
      } catch {
        return [];
      }
    }

    function saveExpenses(expenses) {
      localStorage.setItem(EXPENSES_KEY, JSON.stringify(expenses));
    }

    function loadAdminCategories() {
      try {
        const data = localStorage.getItem(CATEGORIES_KEY);
        return data ? JSON.parse(data) : [];
      } catch {
        return [];
      }
    }

    function formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
    }

    function formatDate(dateStr) {
      return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {
        month: 'short', day: 'numeric', year: 'numeric',
      });
    }

    function populateExpenseCategorySelect() {
      const categories = loadAdminCategories();
      expenseCategorySelect.innerHTML = '';
      categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat;
        option.textContent = cat;
        expenseCategorySelect.appendChild(option);
      });
    }

    function resetExpenseForm() {
      adminEditingExpenseId = null;
      expenseTitleInput.value = '';
      expenseAmountInput.value = '';
      expenseCategorySelect.value = loadAdminCategories()[0] || '';
      expenseDateInput.value = new Date().toISOString().split('T')[0];
      cancelExpenseEditBtn.hidden = true;
      saveExpenseBtn.textContent = 'Save Expense';
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function renderAdminExpenses() {
      const expenses = loadExpenses();
      const rows = expenses.map(expense => `
        <tr class="admin-table-row">
          <td>${formatDate(expense.date)}</td>
          <td>${escapeHtml(expense.title)}</td>
          <td>${escapeHtml(expense.category)}</td>
          <td>${formatCurrency(expense.amount)}</td>
          <td>
            <button class="btn btn-outline btn-sm" data-edit-expense="${expense.id}">Edit</button>
            <button class="btn btn-outline btn-sm text-danger" data-delete-expense="${expense.id}">Delete</button>
          </td>
        </tr>
      `).join('');

      adminExpenseTable.innerHTML = rows || '<tr class="admin-table-row"><td colspan="5">No expenses yet.</td></tr>';
      adminExpenseTable.querySelectorAll('[data-edit-expense]').forEach(btn => {
        btn.addEventListener('click', () => startExpenseEdit(btn.dataset.editExpense));
      });
      adminExpenseTable.querySelectorAll('[data-delete-expense]').forEach(btn => {
        btn.addEventListener('click', () => deleteExpense(btn.dataset.deleteExpense));
      });
    }

    function startExpenseEdit(id) {
      const expenses = loadExpenses();
      const expense = expenses.find(exp => exp.id === id);
      if (!expense) return;
      adminEditingExpenseId = id;
      expenseTitleInput.value = expense.title;
      expenseAmountInput.value = expense.amount;
      expenseCategorySelect.value = expense.category;
      expenseDateInput.value = expense.date;
      cancelExpenseEditBtn.hidden = false;
      saveExpenseBtn.textContent = 'Update Expense';
    }

    function deleteExpense(id) {
      if (!confirm('Delete this expense?')) return;
      const expenses = loadExpenses().filter(exp => exp.id !== id);
      saveExpenses(expenses);
      renderAdminExpenses();
    }

    saveExpenseBtn.addEventListener('click', () => {
      const title = expenseTitleInput.value.trim();
      const amount = parseFloat(expenseAmountInput.value);
      const category = expenseCategorySelect.value;
      const date = expenseDateInput.value;
      const errorEl = document.getElementById('adminExpenseError');
      const successEl = document.getElementById('adminExpenseSuccess');
      const errorText = document.getElementById('adminExpenseErrorText');

      if (!title || !amount || !category || !date) {
        errorText.textContent = 'Please complete all fields.';
        errorEl.style.display = 'flex';
        successEl.style.display = 'none';
        return;
      }

      const expenses = loadExpenses();
      if (adminEditingExpenseId) {
        const index = expenses.findIndex(exp => exp.id === adminEditingExpenseId);
        if (index !== -1) {
          expenses[index] = { id: adminEditingExpenseId, title, amount, category, date };
        }
      } else {
        expenses.push({ id: crypto.randomUUID(), title, amount, category, date });
      }

      saveExpenses(expenses);
      errorEl.style.display = 'none';
      successEl.style.display = 'flex';
      resetExpenseForm();
      renderAdminExpenses();
      setTimeout(() => successEl.style.display = 'none', 3000);
    });

    cancelExpenseEditBtn.addEventListener('click', () => {
      resetExpenseForm();
    });

  <script>
    // تحديد الصفحة النشطة بناءً على URL الحالي
    document.addEventListener('DOMContentLoaded', function() {
      const currentPage = window.location.pathname.split('/').pop() || 'overview.php';
      document.querySelectorAll('.sidebar-nav a').forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
          link.classList.add('active');
        } else {
          link.classList.remove('active');
        }
      });
    });
  </script>
</body>
</html>
