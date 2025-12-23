<?php
require "./database.php";

class Clubs extends Database{
    public $name, $city, $id;
    
    //return an arr you shoud affict it to a variable
    public function getData() : array
    {
        $sql = "SELECT * FROM club;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    public function create() : void
    {
        $sql = "INSERT INTO club (name, city) VALUES(?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$this->name, $this->city]);

    }

    public function delete() : void
    {
        $sql = "DELETE FROM club WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }
}