<?php



class Update{
    public function update(){
        $conn=new mysqli("localhost","root","","system");
        $update="UPDATE users SET name=?, password=?, email=? ,id_role=? WHERE id=?";
        $stmt=$conn->prepare($update);
        $stmt->bind_param('sssii',$_POST['name'],$_POST['password'],$_POST['email'],$_POST['role'],$_GET['id']);
        if($stmt->execute()){
            header('location:../users.php?success=Expense updated successfully');
        }
        else{
            header('location:../users.php?error=Error updating expense: ' . $stmt->error);
        }
    }
}
$u=new Update();
$u->update();
?>
