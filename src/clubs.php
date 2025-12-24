<?php
require_once "./database.php";

class Clubs extends Database
{
    private ?int $id;
    private string $name, $city;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM club;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id): void
    {
        $sql = "SELECT * FROM club WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $club = $stmt->fetch();

        $this->id = $club['id'];
        $this->name = $club['name'];
        $this->city = $club['city'];
    }

    public function getName(int $id) : string{
        $this->getById($id);
        return $this->name;
    }

    public function getCity(int $id) : string{
        $this->getById($id);
        return $this->city;
    }

    //save club in database
    public function save(string $name, string $city): bool
    {
        $sql = "INSERT INTO club (name, city) VALUES(?, ?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$name, $city]);
    }

    //delete club from database
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM club WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //update club from database
    public function update(string $name, string $city, int $id): bool
    {
        $sql = "UPDATE club SET name = ?, city = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$name, $city, $id]);
    }
}