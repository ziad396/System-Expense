<?php
   
class AddUser{
public function insert(){
    $conn=new mysqli("localhost","root","","system");
    $insert="INSERT into users (name,password,email,id_role) Value (?,?,?,?) ";
    $stmt=$conn->prepare($insert);
    $stmt->bind_param("sssi",$_POST['name'],$_POST['password'],$_POST['email'],$_POST['role']);
    if ($stmt->execute()) {
        # code...
            header('location:../users.php?success=Expense added successfully');
    }
    else
    {
           header('location:../users.php?error=Error adding expense: ' . $stmt->error);
    }


    
}

}
$i=new AddUser();
$i->insert();
?>