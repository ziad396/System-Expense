const STORAGE_KEY = 'expenseflow_data';
const CATEGORY_STORAGE_KEY = 'expenseflow_categories';

const DEFAULT_CATEGORIES = [
    'Food & Dining',
    'Transportation',
    'Shopping',
    'Bills & Utilities',
    'Entertainment',
    'Healthcare',
    'Education',
    'Travel',
    'Other',
];

let CATEGORIES = loadCategories();

const views = {
    dashboard: {
        title: 'Dashboard',
        subtitle: 'Overview of your spending',
    },
    expenses: {
        title: 'Expenses',
        subtitle: 'View and manage all your expenses',
    },
    add: {
        title: 'Add Expense',
        subtitle: 'Record a new expense',
    },
};

let expenses = loadExpenses();
let editingId = null;

const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const menuToggle = document.getElementById('menuToggle');
const pageTitle = document.getElementById('pageTitle');
const pageSubtitle = document.getElementById('pageSubtitle');
const expenseForm = document.getElementById('expenseForm');
const expenseIdInput = document.getElementById('expenseId');
const titleInput = document.getElementById('title');
const amountInput = document.getElementById('amount');
const categoryInput = document.getElementById('category');
const dateInput = document.getElementById('date');
const filterCategory = document.getElementById('filterCategory');
const searchInput = document.getElementById('searchInput');
const filterBtn = document.getElementById('filterBtn');
const filterMonth = document.getElementById('filterMonth');
const formTitle = document.getElementById('formTitle');
const formDesc = document.getElementById('formDesc');
const submitBtn = document.getElementById('submitBtn');
const cancelEdit = document.getElementById('cancelEdit');

function loadExpenses() {
    try {
        const data = localStorage.getItem(STORAGE_KEY);
        return data ? JSON.parse(data) : [];
    } catch {
        return [];
    }
}

function saveExpenses() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(expenses));
}

function loadCategories() {
    try {
        const data = localStorage.getItem(CATEGORY_STORAGE_KEY);
        const stored = data ? JSON.parse(data) : [];
        return Array.isArray(stored) && stored.length ? stored : [...DEFAULT_CATEGORIES];
    } catch {
        return [...DEFAULT_CATEGORIES];
    }
}

function saveCategories() {
    localStorage.setItem(CATEGORY_STORAGE_KEY, JSON.stringify(CATEGORIES));
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
}

function formatDate(dateStr) {
    return new Date(dateStr + 'T00:00:00').toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}

function getCurrentMonthKey() {
    const now = new Date();
    return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}`;
}

function populateCategorySelects() {
    const selects = [categoryInput, filterCategory];
    selects.forEach((select, index) => {
        const current = select.value;
        if (index === 1) {
            select.innerHTML = '<option value="">All categories</option>';
        } else {
            select.innerHTML = '';
        }
        CATEGORIES.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            select.appendChild(option);
        });
        if (current) select.value = current;
    });
}

function switchView(viewName) {
    document.querySelectorAll('.nav-item').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.view === viewName);
    });
    document.querySelectorAll('.view').forEach(view => {
        view.classList.toggle('active', view.id === `view-${viewName}`);
    });

    const config = views[viewName];
    pageTitle.textContent = config.title;
    pageSubtitle.textContent = config.subtitle;

    sidebar.classList.remove('open');
    overlay.classList.remove('show');

    if (viewName === 'dashboard') renderDashboard();
    if (viewName === 'expenses') renderExpenseTable();
}

function resetForm() {
    editingId = null;
    expenseForm.reset();
    expenseIdInput.value = '';
    dateInput.value = new Date().toISOString().split('T')[0];
    formTitle.textContent = 'Add New Expense';
    formDesc.textContent = 'Fill in the details below to record a new expense.';
    submitBtn.textContent = 'Save Expense';
    cancelEdit.hidden = true;
}

function startEdit(id) {
    const expense = expenses.find(e => e.id === id);
    if (!expense) return;

    editingId = id;
    expenseIdInput.value = id;
    titleInput.value = expense.title;
    amountInput.value = expense.amount;
    categoryInput.value = expense.category;
    dateInput.value = expense.date;
    formTitle.textContent = 'Edit Expense';
    formDesc.textContent = 'Update the expense details below.';
    submitBtn.textContent = 'Update Expense';
    cancelEdit.hidden = false;
    switchView('add');
}

function deleteExpense(id) {
    if (!confirm('Delete this expense?')) return;
    expenses = expenses.filter(e => e.id !== id);
    saveExpenses();
    renderDashboard();
    renderExpenseTable();
}

function getFilteredExpenses() {
    const search = searchInput.value.trim().toLowerCase();
    const category = filterCategory.value;
    const month = filterMonth.value;

    return expenses
        .filter(e => {
            const matchesSearch = !search || [
                e.title,
                e.category,
            ].some(value => value.toLowerCase().includes(search));

            if (!matchesSearch) return false;
            if (category && e.category !== category) return false;
            if (month && !e.date.startsWith(month)) return false;
            return true;
        })
        .sort((a, b) => new Date(b.date) - new Date(a.date));
}

function renderDashboard() {
    const total = expenses.reduce((sum, e) => sum + e.amount, 0);
    const monthKey = getCurrentMonthKey();
    const monthExpenses = expenses.filter(e => e.date.startsWith(monthKey));
    const monthTotal = monthExpenses.reduce((sum, e) => sum + e.amount, 0);
    const average = expenses.length ? total / expenses.length : 0;
    const categoriesUsed = new Set(expenses.map(e => e.category)).size;

    document.getElementById('statTotal').textContent = formatCurrency(total);
    document.getElementById('statMonth').textContent = formatCurrency(monthTotal);
    document.getElementById('statMonthMeta').textContent =
        `${monthExpenses.length} transaction${monthExpenses.length !== 1 ? 's' : ''}`;
    document.getElementById('statAverage').textContent = formatCurrency(average);
    document.getElementById('statCategories').textContent = categoriesUsed;

    renderCategoryBars();
    renderRecentList();
}

function renderCategoryBars() {
    const container = document.getElementById('categoryBars');

    if (!expenses.length) {
        container.innerHTML = '<p class="empty-state">No expenses yet. Add your first expense to see a breakdown.</p>';
        return;
    }

    const totals = {};
    expenses.forEach(e => {
        totals[e.category] = (totals[e.category] || 0) + e.amount;
    });

    const sorted = Object.entries(totals).sort((a, b) => b[1] - a[1]);
    const max = sorted[0][1];

    container.innerHTML = sorted.map(([cat, amount]) => {
        const pct = (amount / max) * 100;
        return `
            <div class="category-bar-item">
                <div class="category-bar-header">
                    <span>${cat}</span>
                    <span>${formatCurrency(amount)}</span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill" style="width: ${pct}%"></div>
                </div>
            </div>
        `;
    }).join('');
}

function renderRecentList() {
    const container = document.getElementById('recentList');
    const recent = [...expenses]
        .sort((a, b) => new Date(b.date) - new Date(a.date))
        .slice(0, 5);

    if (!recent.length) {
        container.innerHTML = '<p class="empty-state">No recent expenses.</p>';
        return;
    }

    container.innerHTML = recent.map(e => `
        <div class="recent-item">
            <div class="recent-item-info">
                <strong>${escapeHtml(e.title)}</strong>
                <span>${e.category} · ${formatDate(e.date)}</span>
            </div>
            <span class="recent-item-amount">${formatCurrency(e.amount)}</span>
        </div>
    `).join('');
}

function renderExpenseTable() {
    const tbody = document.getElementById('expenseTableBody');
    const filtered = getFilteredExpenses();

    document.getElementById('expenseCount').textContent =
        `${filtered.length} item${filtered.length !== 1 ? 's' : ''}`;

    if (!filtered.length) {
        tbody.innerHTML = '<tr class="empty-row"><td colspan="5">No expenses found.</td></tr>';
        return;
    }

    tbody.innerHTML = filtered.map(e => `
        <tr>
            <td>${formatDate(e.date)}</td>
            <td>${escapeHtml(e.title)}</td>
            <td><span class="category-tag">${escapeHtml(e.category)}</span></td>
            <td class="amount-cell">${formatCurrency(e.amount)}</td>
            <td>
                <div class="table-actions">
                    <button class="icon-btn" data-edit="${e.id}">Edit</button>
                    <button class="icon-btn danger" data-delete="${e.id}">Delete</button>
                </div>
            </td>
        </tr>
    `).join('');

    tbody.querySelectorAll('[data-edit]').forEach(btn => {
        btn.addEventListener('click', () => startEdit(btn.dataset.edit));
    });

    tbody.querySelectorAll('[data-delete]').forEach(btn => {
        btn.addEventListener('click', () => deleteExpense(btn.dataset.delete));
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

document.querySelectorAll('.nav-item').forEach(btn => {
    if (!btn.dataset.view) return;
    btn.addEventListener('click', (event) => {
        event.preventDefault();
        if (btn.dataset.view === 'add') resetForm();
        switchView(btn.dataset.view);
    });
});

document.querySelectorAll('[data-view-link]').forEach(btn => {
    btn.addEventListener('click', () => switchView(btn.dataset.viewLink));
});

document.getElementById('quickAddBtn').addEventListener('click', () => {
    resetForm();
    switchView('add');
});

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
});

expenseForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const data = {
        title: titleInput.value.trim(),
        amount: parseFloat(amountInput.value),
        category: categoryInput.value,
        date: dateInput.value,
    };

    if (editingId) {
        expenses = expenses.map(item =>
            item.id === editingId ? { ...item, ...data } : item
        );
    } else {
        expenses.push({
            id: crypto.randomUUID(),
            ...data,
        });
    }

    saveExpenses();
    resetForm();
    switchView('expenses');
});

cancelEdit.addEventListener('click', () => {
    resetForm();
    switchView('expenses');
});

searchInput.addEventListener('input', renderExpenseTable);
filterBtn.addEventListener('click', renderExpenseTable);
filterCategory.addEventListener('change', renderExpenseTable);
filterMonth.addEventListener('change', renderExpenseTable);

document.getElementById('clearFilters').addEventListener('click', () => {
    searchInput.value = '';
    filterCategory.value = '';
    filterMonth.value = '';
    renderExpenseTable();
});

const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
        window.location.href = 'login.html';
    });
}

populateCategorySelects();
resetForm();
renderDashboard();
