<?php

class Register
{
    public function register()
    {
         $conn = new mysqli("localhost", "root", "", "system");
        $role='user';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                header('Location: ../register.php?error=' . urlencode('Please complete all fields.'));
                exit;
            }

            if (strlen($_POST['password']) < 6) {
                header('Location: ../register.php?error=' . urlencode('Password must be at least 8 characters long.'));
                exit;
            }

            if ($_POST['password'] !== $_POST['confirm_password']) {
                header('Location: ../register.php?error=' . urlencode('Passwords do not match.'));
                exit;
            }

            $select = "SELECT * FROM users WHERE email = ?";

            $stmt = $conn->prepare($select);
            $stmt->bind_param("s", $_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->fetch_assoc()) {
                
                header('Location: ../register.php?error=' . urlencode('Email already exists.'));
                exit;
            } else {
                $insert = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insert);
                $stmt->bind_param("ssss", $_POST['username'], $_POST['email'], $_POST['password'], $role);
                if ($stmt->execute()) {
                    session_start();
                    $_SESSION['id'] = $stmt->insert_id;
                    header("Location: ../expense.php" );

                    exit;
                } else {
                    header('Location: ../register.php?error=' . urlencode('Error: ' . $stmt->error));
                    exit;
                }
            }
        }
    }
}

$r = new Register();
$r->register();
?>
<!-- <form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" >
    <input type="email" name="email" placeholder="Email" >
    <input type="password" name="password" placeholder="Password" >
    <input type="password" name="confirm_password" placeholder="Confirm Password" >
    <input type="submit" value="Register">
</form> -->