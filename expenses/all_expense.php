<?php
// session_start();

class Expense
{
  

    public function getAll()
    {
       
        $conn = new mysqli("localhost","root","","system");
        $result = $conn->query("SELECT * FROM expenses");

        $expenses = [];

        while($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }

        
        return $expenses;
    }
    public function getById($id){
        $conn = new mysqli("localhost","root","","system");
        $select = "SELECT * FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

public function getByUserId($id)
{
    $conn = new mysqli("localhost","root","","system");

    $select = "SELECT * FROM expenses WHERE id_user = ?";
    $stmt = $conn->prepare($select);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
    public function filter($title,$category){
        $conn = new mysqli("localhost","root","","system");
        $select = "SELECT * FROM expenses WHERE title LIKE ? AND id_category LIKE ?";
        $stmt = $conn->prepare($select);    
        $title = "%$title%";
        $category = "%$category%";
        $stmt->bind_param("ss", $title, $category);
        $stmt->execute();   

        $result = $stmt->get_result();
        $expenses = [];
        while($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }

        return $expenses;
    }
    public function sumExpenses()
    {
        $id=$_SESSION['id'];
        $conn = new mysqli("localhost","root","","system");
        $select= "SELECT SUM(amount) as total FROM expenses where id_user='$id'";
        $result = $conn->query($select);

        $row = $result->fetch_assoc();
        return $row['total'];
    }
       public function numCategory($id){
        $conn=new mysqli("localhost","root","","system");

        $select="SELECT COUNT(DISTINCT id_category) AS categories_count FROM expenses WHERE id_user=?";
        $stmt=$conn->prepare($select);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();


    }
    
}

// $x=new Expense();
// $expenses = $x->getById(1);
// print_r($expenses);

// $expenses = $x->getAll();


?>