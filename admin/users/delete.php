<?php
class Delete{
    public function delete(){
        $conn= new mysqli("localhost", "root", "", "system");
        
        $delete="DELETE FROM users WHERE id=?";
        $stmt=$conn->prepare($delete);  
        $stmt->bind_param("i",$_GET['id']);
        if($stmt->execute()){
            header('location:../users.php?success=Expense deleted successfully');
        }
        else{
            header('location:../users.php?error=Error deleting expense: ' . $stmt->error);
            }

    }
}
$d=new Delete();
$d->delete();

?>