<?php
require_once 'role/select.php';
$role = new RoleSelect();
$roles = $role->getAllRoles();


?>

<article class="panel mt-4">
            <h2>Add New User</h2>
            <form action="users/do_insert.php" method="post">
             <div class="alert-error" id="adminUserError">
              <i class="fa-solid fa-circle-exclamation"></i>
              <span id="adminUserErrorText">Please complete all fields.</span>
            </div>
            <div class="alert-success" id="adminUserSuccess">
              <i class="fa-solid fa-circle-check"></i>
              <span>User added successfully.</span>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control-custom" id="newUserName"  name="name" placeholder="Name" />
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control-custom" id="newUserEmail"  name="email" placeholder="email@example.com" />
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control-custom" id="newUserEmail" name="password" placeholder="password" />
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Role</label>
              <select class="form-control-custom" id="newUserRole" name="role">
                <?php
                foreach ($roles as $role) {
                 ?>
                  <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
                 <?php
                }
                ?>
              
              </select>
               <div class="form-actions">
                 <button type="submit" class="btn btn-primary" id="submitBtn">Add User</button>
                </div>
            </div>
            </form>
           
            
          </article>