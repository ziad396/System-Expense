<?php
class Category{
    public function getAll(){
        $con=new mysqli("localhost","root","","system");
        $select="SELECT * FROM category";
        $result=$con->query($select);
        $categories=[]; 
        while($row=$result->fetch_assoc()){
            $categories[]=$row;
        }
        return $categories;


    }
    public function getById($id){
        $conn=new mysqli("localhost","root","","system");
        $select="SELECT * FROM category Where id=?";
        $stmt=$conn->prepare($select);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
 


}

?>