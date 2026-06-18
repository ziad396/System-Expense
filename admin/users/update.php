
<?php
require_once "select.php";
require_once "role/select.php";
$roleSelect = new RoleSelect();
$roles=$roleSelect->getAllRoles();
$users=new User();
$user=$users->getById($_GET['id']);

?>



<article class="panel mt-4">
            <h2>Add New User</h2>
            <form action="users/do_edit.php?id=<?=$user['id']?>" method="post">
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
              <input type="text" class="form-control-custom" id="newUserName" name="name" value="<?=$user['name']?>" placeholder="Name" />
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control-custom" id="newUserEmail" name="email" value="<?=$user['email']?>" placeholder="email@example.com" />
            </div>
            <div class="form-group mb-3">
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control-custom" id="newUserEmail" name="password" value="<?=$user['password']?>" placeholder="password" />
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Role</label>
              <select class="form-control-custom" name="role" id="newUserRole">
            <?php
            foreach ($roles as $role) {
             ?>
              <option value="<?= $role['id'] ?>" <?php if ($role['id'] == $user['id_role']) {
                echo 'selected';
              } ?>><?= $role['role'] ?></option>
             <?php
            }
            ?>
               
              </select>
            </div>
             <div class="form-actions">
                 <button type="submit" class="btn btn-primary" id="submitBtn">Update User</button>
                </div>
            </form>
            
            
          </article>