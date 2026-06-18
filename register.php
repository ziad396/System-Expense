<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register — ExpenseIQ</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="css/auth.css" rel="stylesheet"/>
</head>
<?php
// show server-side messages if provided
$serverError = isset($_GET['error']) ? urldecode($_GET['error']) : '';
$serverSuccess = isset($_GET['success']) ? urldecode($_GET['success']) : '';
?>
<body>
  <div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>

  <div class="auth-card">
    <form id="registerForm" action="user/register.php" method="post">
    <div class="brand-logo">
      <div class="brand-icon"><i class="fa-solid fa-chart-pie"></i></div>
      <div class="brand-name">Expense<span>IQ</span></div>
    </div>

    <h1 class="auth-title">Create your account</h1>
    <p class="auth-subtitle">Set up your ExpenseIQ account and start managing your budget.</p>

    <div class="alert-error" id="registerError">
      <i class="fa-solid fa-circle-exclamation"></i>
      <span id="registerErrorText">Please complete all fields.</span>
    </div>
    <div class="alert-success" id="registerSuccess">
      <i class="fa-solid fa-circle-check"></i>
      <span>Account created successfully. Redirecting to login…</span>
    </div>

    <div class="input-group-custom">
      <label class="form-label">Full Name</label>
      <i class="fa-solid fa-user input-icon"></i>
      <input name="fullname" type="text" class="form-control-custom" id="fullName" placeholder="Your name"/>
    </div>

    <div class="input-group-custom">
      <label class="form-label">Email Address</label>
      <i class="fa-solid fa-envelope input-icon"></i>
      <input name="email" type="email" class="form-control-custom" id="registerEmail" placeholder="you@example.com"/>
    </div>

    <div class="input-group-custom">
      <label class="form-label">Password</label>
      <i class="fa-solid fa-lock input-icon"></i>
      <input name="password" type="password" class="form-control-custom" id="registerPassword" placeholder="Create a password"/>
      <i class="fa-solid fa-eye password-toggle" id="toggleRegisterPassword"></i>
    </div>

    <div class="input-group-custom">
      <label class="form-label">Confirm Password</label>
      <i class="fa-solid fa-lock input-icon"></i>
      <input name="confirmPassword" type="password" class="form-control-custom" id="confirmPassword" placeholder="Repeat password"/>
    </div>

    <button type="submit" class="btn-primary-custom" id="registerBtn">
      <i class="fa-solid fa-user-plus me-2"></i>Create account
    </button>

    <div class="auth-footer">
      Already have an account? <a href="login.php">Sign in</a>
    </div>
    </form>
  </div>

  <script>
    window.serverMessages = {
      error: <?php echo json_encode($serverError); ?>,
      success: <?php echo json_encode($serverSuccess); ?>
    };
  </script>
  <script src="js/auth.js"></script>
</body>
</html>
