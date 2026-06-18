<?php
   
class AddCategory{
public function insert(){
    $conn=new mysqli("localhost","root","","system");
    $insert="INSERT into category (name) Value (?) ";
    $stmt=$conn->prepare($insert);
    $stmt->bind_param("s",$_POST['name']);
    if ($stmt->execute()) {
        # code...
            header('location:../categories.php?success=Expense added successfully');
    }
    else
    {
           header('location:../categories.php?error=Error adding expense: ' . $stmt->error);
    }


    
}

}
$i=new AddCategory();
$i->insert();
?>