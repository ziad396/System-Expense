<?php
session_start();

Class Insert{
    public function create(){
        $conn= new mysqli("localhost", "root", "", "system");
        
        $insert="INSERT into expenses (title,amount,id_category,date,id_user) Values (?,?,?,?,?)";
        $stmt=$conn->prepare($insert);
        $stmt->bind_param('sissi',$_POST['title'],$_POST['amount'],$_POST['category'],$_POST['date'],$_SESSION['id']);
        if($stmt->execute()){
            header('location:../expense.php?success=Expense added successfully');
        }
        else{
            header('location:../expense.php?error=Error adding expense: ' . $stmt->error);
        }
        

    }
}

$i=new Insert();
$i->create();
?>