<?php

class Delete{
    public function delete(){
        $conn= new mysqli("localhost", "root", "", "system");
        
        $delete="DELETE FROM expenses WHERE id=?";
        $stmt=$conn->prepare($delete);  
        $stmt->bind_param("i",$_GET['id']);
        if($stmt->execute()){
            header('location:../expenses.php?success=Expense deleted successfully');
        }
        else{
            header('location:../expenses.php?error=Error deleting expense: ' . $stmt->error);
            }

    }
}
$d=new Delete();
$d->delete();
?>
