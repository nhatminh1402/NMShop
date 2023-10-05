<?php

class AdminModel extends DataConnect{
    protected $table = "Admin";

    function isAccountExist($Email, $passWord) {
        $sql = "select * from ".$this->table. " where email = ? and password = ?";
        $query = $this->conn->prepare($sql);
        $query->execute([$Email, $passWord]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
