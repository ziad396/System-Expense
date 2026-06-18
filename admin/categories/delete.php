<?php
class Delete{
    public function delete(){
        $conn= new mysqli("localhost", "root", "", "system");
        
        $delete="DELETE FROM category WHERE id=?";
        $stmt=$conn->prepare($delete);  
        $stmt->bind_param("i",$_GET['id']);
        if($stmt->execute()){
            header('location:../categories.php?success=Expense deleted successfully');
        }
        else{
            header('location:../categories.php?error=Error deleting expense: ' . $stmt->error);
            }

    }
}
$d=new Delete();
$d->delete();

?>