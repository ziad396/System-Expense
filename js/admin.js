const USERS_KEY = 'expenseflow_admin_users';
const CATEGORIES_KEY = 'expenseflow_categories';
const EXPENSES_KEY = 'expenseflow_data';

let adminEditingExpenseId = null;

const expenseTitleInput = document.getElementById('expenseTitle');
const expenseAmountInput = document.getElementById('expenseAmount');
const expenseCategorySelect = document.getElementById('expenseCategory');
const expenseDateInput = document.getElementById('expenseDate');
const saveExpenseBtn = document.getElementById('saveExpenseBtn');
const cancelExpenseEditBtn = document.getElementById('cancelExpenseEdit');
const adminExpenseTable = document.getElementById('adminExpenseTable');

function switchAdminView(view) {
  document.querySelectorAll('[data-admin-view]').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.adminView === view);
  });
  document.querySelectorAll('.view').forEach(section => {
    section.classList.toggle('active', section.id === `view-${view}`);
  });

  const titles = {
    overview: { title: 'Admin Panel', subtitle: 'Manage users and expense categories locally.' },
    users: { title: 'Users', subtitle: 'Add and manage local users.' },
    categories: { title: 'Categories', subtitle: 'Create and review expense categories.' },
    expenses: { title: 'Expenses', subtitle: 'Manage expense entries across the app.' },
  };
  const active = titles[view] || titles.overview;
  document.getElementById('adminTitle').textContent = active.title;
  document.getElementById('adminSubtitle').textContent = active.subtitle;

  if (view === 'expenses') {
    populateExpenseCategorySelect();
    renderAdminExpenses();
  }
}

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

function formatCurrency(amount) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
}

function formatDate(dateStr) {
  return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric',
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

document.querySelectorAll('[data-admin-view]').forEach(btn => {
  btn.addEventListener('click', () => switchAdminView(btn.dataset.adminView));
});

document.getElementById('backToDashboard').addEventListener('click', () => {
  window.location.href = 'dashboard.php';
});

function loadAdminUsers() {
  try {
    const data = localStorage.getItem(USERS_KEY);
    return data ? JSON.parse(data) : [];
  } catch {
    return [];
  }
}

function saveAdminUsers(users) {
  localStorage.setItem(USERS_KEY, JSON.stringify(users));
}

function loadAdminCategories() {
  try {
    const data = localStorage.getItem(CATEGORIES_KEY);
    return data ? JSON.parse(data) : [];
  } catch {
    return [];
  }
}

function saveAdminCategories(categories) {
  localStorage.setItem(CATEGORIES_KEY, JSON.stringify(categories));
}

function renderUsers() {
  const users = loadAdminUsers();
  const tbody = document.getElementById('userTableBody');
  if (!users.length) {
    tbody.innerHTML = '<tr class="admin-table-row"><td colspan="4">No users added yet.</td></tr>';
    return;
  }
  tbody.innerHTML = users.map(user => `
    <tr class="admin-table-row">
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.role}</td>
      <td>${new Date(user.addedAt).toLocaleString()}</td>
    </tr>
  `).join('');
}

function renderCategories() {
  const categories = loadAdminCategories();
  const list = document.getElementById('categoryList');
  if (!categories.length) {
    list.innerHTML = '<li>No categories defined yet.</li>';
    return;
  }
  list.innerHTML = categories.map(cat => `<li><span>${cat}</span></li>`).join('');
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

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
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
  switchAdminView('expenses');
}

function deleteExpense(id) {
  if (!confirm('Delete this expense?')) return;
  const expenses = loadExpenses().filter(exp => exp.id !== id);
  saveExpenses(expenses);
  renderAdminExpenses();
  updateOverviewStats();
}

function updateOverviewStats() {
  document.getElementById('statUsers').textContent = loadAdminUsers().length;
  document.getElementById('statCategories').textContent = loadAdminCategories().length;
  document.getElementById('statExpenses').textContent = loadExpenses().length;
}

document.getElementById('addUserBtn').addEventListener('click', () => {
  const name = document.getElementById('newUserName').value.trim();
  const email = document.getElementById('newUserEmail').value.trim();
  const role = document.getElementById('newUserRole').value;
  const errorEl = document.getElementById('adminUserError');
  const successEl = document.getElementById('adminUserSuccess');
  const errorText = document.getElementById('adminUserErrorText');

  if (!name || !email) {
    errorText.textContent = 'Please complete all fields.';
    errorEl.style.display = 'flex';
    successEl.style.display = 'none';
    return;
  }

  const users = loadAdminUsers();
  users.push({ name, email, role, addedAt: new Date().toISOString() });
  saveAdminUsers(users);
  errorEl.style.display = 'none';
  successEl.style.display = 'flex';
  document.getElementById('newUserName').value = '';
  document.getElementById('newUserEmail').value = '';
  renderUsers();
  updateOverviewStats();
});

document.getElementById('addCategoryBtn').addEventListener('click', () => {
  const name = document.getElementById('newCategoryName').value.trim();
  const errorEl = document.getElementById('adminCategoryError');
  const successEl = document.getElementById('adminCategorySuccess');
  const errorText = document.getElementById('adminCategoryErrorText');

  if (!name) {
    errorText.textContent = 'Category name is required.';
    errorEl.style.display = 'flex';
    successEl.style.display = 'none';
    return;
  }

  const categories = loadAdminCategories();
  if (categories.includes(name)) {
    errorText.textContent = 'This category already exists.';
    errorEl.style.display = 'flex';
    successEl.style.display = 'none';
    return;
  }

  categories.push(name);
  saveAdminCategories(categories);
  errorEl.style.display = 'none';
  successEl.style.display = 'flex';
  document.getElementById('newCategoryName').value = '';
  renderCategories();
  populateExpenseCategorySelect();
  updateOverviewStats();
});

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
  updateOverviewStats();
});

cancelExpenseEditBtn.addEventListener('click', () => {
  resetExpenseForm();
});

document.getElementById('adminLogout').addEventListener('click', () => {
  window.location.href = 'login.html';
});

document.addEventListener('DOMContentLoaded', () => {
  renderUsers();
  renderCategories();
  populateExpenseCategorySelect();
  renderAdminExpenses();
  updateOverviewStats();
});
