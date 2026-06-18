<?php
class Login{
    public function login(){
     $conn = new mysqli("localhost", "root", "", "system");
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(empty($_POST['email']) || empty($_POST['password'])){
            echo "All fields are required.";
        }
        elseif (strlen($_POST['password']) < 6) {
            echo "Password must be at least 8 characters long.";
        } 
        else {          
            # code...
            $select = "SELECT * FROM users WHERE email = ? AND password = ?";
            $stmt=$conn->prepare($select);
            $stmt->bind_param("ss",$_POST['email'],$_POST['password']);
            $stmt->execute();
          $result = $stmt->get_result();
           
            if($result->num_rows){
                $user = $result->fetch_assoc();
                session_start();
                $_SESSION['id']=$user['id'];
                if ($user['id_role']==1) {
                    # code...

                      header('location:../admin/overview.php');
                      exit();
                }
                header('location:../expense.php');
            }
            else{
                header('location:../login.php?error=Invalid email or password');
            }
           
        }
        
    }
       
}

}
$l = new Login();
$l->login();
?>



