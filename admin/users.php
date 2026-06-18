<?php
include "sidbar.php";
require "users/select.php";
require "role/select.php";
$roleSelect = new RoleSelect();

$user=new User();
$users=$user->getAllUsers();
?>

    <div class="main admin-main">
      <header class="topbar admin-topbar">
        <div class="topbar-title">
          <h1 class="admin-title">Users</h1>
          <p class="admin-subtitle">Add and manage local users.</p>
        </div>
      </header>

      <main class="content admin-content">
        <section class="view active" id="view-users">
          <?php
          if (isset($_GET['method'])&& $_GET['method']==='insert') {
            # code...
            include "users/insert.php";
            exit();
          }
          if (isset($_GET['method'])&& $_GET['method']==='update') {
            # code...
            include "users/update.php";
            exit();
          }
          ?>

 

          <article class="panel mt-4">
            <h2>Saved Users</h2>
            <table class="admin-table">
              <thead>
                <tr>
                    <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Added</th>
                </tr>
              </thead>
              <tbody id="userTableBody">
                <?php
                        foreach($users as $data)
                        {
                        $role = $roleSelect->getRoleById($data['id_role']);
                            ?>

                            <tr>

                                <td><?= $data['id'] ?></td>

                                <td><?= $data['name'] ?></td>

                                <td>
                                    <?= $data['email'] ?>
                                </td>

                                <td><?=$role['role'] ?></td>


                                <td>

                                    <a
                                        href="?method=update&id=<?= $data['id'] ?>"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Update
                                    </a>

                                    <a
                                        href="users/delete.php?id=<?= $data['id'] ?>"
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
             <button class="btn btn-primary" id="addUserBtn"><i class="fa-solid fa-user-plus me-2"></i><a href="?method=insert">Add User</a></button>
          </article>
        </section>
      </main>
    </div>
  </div>

  <script>
    const USERS_KEY = 'expenseflow_admin_users';

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
      setTimeout(() => successEl.style.display = 'none', 3000);
    });

  <script>
  
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
