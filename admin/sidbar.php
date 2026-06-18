<?php
include "../function/connect.php";
session_start();
if (!isset($_SESSION['id'])) {
    # code...
    header("location:../login.php");
}
else
{
    $id=$_SESSION['id'];
    $select="SELECT * FROM users where id='$id'";
    $row=$conn->query($select);
    $result=$row->fetch_assoc();
    if ($result['id_role']!=1) {
        # code...
        header('location:../dashboard.php');

    
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — ExpenseIQ</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="../styles.css" rel="stylesheet"/>
  <link href="../css/auth.css" rel="stylesheet"/>
  <link href="../css/admin.css" rel="stylesheet"/>
</head>
<body>
  <div class="app admin-app">
    <aside class="sidebar admin-sidebar">
      <div class="sidebar-brand">
        <div class="brand-icon">A</div>
        <div>
          <strong>Admin Panel</strong>
          <span>Control center</span>
        </div>
      </div>
      <nav class="sidebar-nav admin-nav">
        <a href="overview.php" class="nav-item active"><span class="nav-icon">▦</span> Overview</a>
        <a href="users.php" class="nav-item"><span class="nav-icon">👤</span> Users</a>
        <a href="categories.php" class="nav-item"><span class="nav-icon">🏷</span> Categories</a>
        <a href="expenses.php" class="nav-item"><span class="nav-icon">💰</span> Expenses</a>
      </nav>
      <div class="sidebar-footer admin-sidebar-footer">
        <!-- <button class="btn btn-outline"  ><i class="fa-solid fa-arrow-left me-2"></i><a href="epenseve"></a></button> -->
        <!-- <button class="btn btn-outline" id="adminLogout">Logout</button> -->
      </div>
    </aside>

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