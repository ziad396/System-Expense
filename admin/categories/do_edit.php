<?php



class Update{
    public function update(){
        $conn=new mysqli("localhost","root","","system");
        $update="UPDATE category SET name=? WHERE id=?";
        $stmt=$conn->prepare($update);
        $stmt->bind_param('si',$_POST['name'],$_GET['id']);
        if($stmt->execute()){
            header('location:../categories.php?success=Expense updated successfully');
        }
        else{
            header('location:../categories.php?error=Error updating expense: ' . $stmt->error);
        }
    }
}
$u=new Update();
$u->update();
?>
