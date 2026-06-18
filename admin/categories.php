<?php
include "sidbar.php";
require_once "../category/category.php";
$category=new Category();
$categories=$category->getAll();
?>

    <div class="main admin-main">
      <header class="topbar admin-topbar">
        <div class="topbar-title">
          <h1 class="admin-title">Categories</h1>
          <p class="admin-subtitle">Create and review expense categories.</p>
        </div>
      </header>
      <?php
      if (isset($_GET['method']) && $_GET['method']==='insert') {
        # code...
        include "categories/insert.php";
        exit();
      }
      if (isset($_GET['method']) && $_GET['method']==='update') {
        # code...
        include "categories/update.php";
        exit();
      }
      ?>

          <article class="panel mt-4">
            <h2>Expense List</h2>
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Id</th>
   
                  <th>Category</th>
                  <th>Actions</th>

                </tr>
              </thead>
              <tbody id="adminExpenseTable">
                 <?php

                        foreach($categories as $data)
                        {
                            ?>

                            <tr>

                                <td><?= $data['id'] ?></td>

                                <td><?= $data['name'] ?></td>

                               
                                <td>
                                    <a
                                        href="?method=update&id=<?= $data['id'] ?>"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Update
                                    </a>

                                    <a
                                        href="categories/delete.php?id=<?= $data['id'] ?>"
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
                                    <a
                                        href="?method=insert"
                                        class="btn btn-danger btn-sm">
                                            Insert Category
                                    </a>
    </div>
  </div>

  <script>
    const CATEGORIES_KEY = 'expenseflow_categories';

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

    function renderCategories() {
      const categories = loadAdminCategories();
      const list = document.getElementById('categoryList');
      if (!categories.length) {
        list.innerHTML = '<li>No categories defined yet.</li>';
        return;
      }
      list.innerHTML = categories.map(cat => `<li><span>${cat}</span></li>`).join('');
    }

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
      setTimeout(() => successEl.style.display = 'none', 3000);
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
