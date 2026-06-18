<?php
class RoleSelect {
 

    public function getAllRoles() {
        $conn=new mysqli("localhost","root","","system");
        $query = "SELECT * FROM role";
        $result = $conn->query($query);
        $roles = [];
        while($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
        return $roles;
    }
    public function getRoleById($id) {
        $conn=new mysqli("localhost","root","","system");
        $query = "SELECT * FROM role WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

?>