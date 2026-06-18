<?
session_start();
if (isset($_POST['id'])) {
  # code...
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — ExpenseIQ</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="css/auth.css" rel="stylesheet"/>
</head>
<body>
  <form id="loginForm" action="user/login.php" method="post">
  <div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>

  <div class="auth-card">
    <div class="brand-logo">
      <div class="brand-icon"><i class="fa-solid fa-chart-pie"></i></div>
      <div class="brand-name">Expense<span>IQ</span></div>
    </div>

    <h1 class="auth-title">Welcome back</h1>
    <p class="auth-subtitle">Sign in to your account to continue</p>

    <div class="alert-error" id="loginError">
      <i class="fa-solid fa-circle-exclamation"></i>
      <span>Invalid email or password. Please try again.</span>
    </div>

    <div class="input-group-custom">
      <label class="form-label">Email Address</label>
      <i class="fa-solid fa-envelope input-icon"></i>
      <input name="email" type="email" class="form-control-custom" id="email" placeholder="admin@expenseiq.com" />
    </div>

    <div class="input-group-custom">
      <label class="form-label">Password</label>
      <i class="fa-solid fa-lock input-icon"></i>
      <input name="password" type="password" class="form-control-custom" id="password" placeholder="Enter your password" />
      <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rememberMe" checked/>
        <label class="form-check-label" for="rememberMe">Remember me</label>
      </div>
      <a href="#" class="forgot-link">Forgot password?</a>
    </div>

    <button type="submit" class="btn-primary-custom">
      <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>
      Sign In
    </button>

    <div class="auth-footer">
      Don't have an account? <a href="register.php">Create one free</a>
    </div>
  </div>
</form>
  <script src="js/auth.js"></script>
</body>
</html>