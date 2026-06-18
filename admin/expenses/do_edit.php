<?php
class Update{
    public function update(){
        $conn=new mysqli("localhost","root","","system");
        $update="UPDATE expenses SET title=?, amount=?, id_category=?, date=? WHERE id=?";
        $stmt=$conn->prepare($update);
        $stmt->bind_param('sissi',$_POST['title'],$_POST['amount'],$_POST['category'],$_POST['date'],$_GET['id']);
        if($stmt->execute()){
            header('location:../expenses.php?success=Expense updated successfully');
        }
        else{
            header('location:../expenses.php?error=Error updating expense: ' . $stmt->error);
        }
    }
}
$u=new Update();
$u->update();
?>