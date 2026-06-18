<?php

class User{

public function getAllUsers(){
    $conn=new mysqli("localhost","root","","system");
    $select="SELECT * FROM users where id_role!='1' ";
    $result=$conn->query($select);
    $users=[];
   while ($row=$result->fetch_assoc()) {
    # code...
    $users[]=$row;

   }
    return $users;

}
public function getById($id){
 $conn=new mysqli("localhost","root","","system");
 $select="SELECT * FROM users where id=?";
 $stmt=$conn->prepare($select);
 $stmt->bind_param('i',$id);
 $stmt->execute();
 return $stmt->get_result()->fetch_assoc();    
}

}
// $x=new User();

// // $x->getAllUsers();
// print_r($x->getById(2));


?>