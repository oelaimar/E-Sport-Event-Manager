<?php
require_once "database.php";

class Sponsors extends Database
{
    private ?int $id;
    private string $name;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM sponsor;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id): void
    {
        $sql = "SELECT * FROM sponsor WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $sponsor = $stmt->fetch();

        $this->id = (int)$sponsor['id'];
        $this->name = (int)$sponsor['name'];
    }

    public function getName(int $id): string
    {
        $this->getById($id);
        return $this->name;
    }

    public function save(string $name): bool
    {
        $sql = "INSERT INTO player (name) VALUES(?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$name]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM matches WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(string $name, int $id): bool
    {
        $sql = "UPDATE player SET name = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$name, $id]);
    }
}
