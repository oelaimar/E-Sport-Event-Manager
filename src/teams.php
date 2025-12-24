<?php
require_once "./database.php";

class Teams extends Database
{
    private ?int $id;
    private string $name, $game;
    private int $club_id;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM team;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id): void
    {
        $sql = "SELECT * FROM team WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $team = $stmt->fetch();

        $this->id = (int)$team['id'];
        $this->name = $team['name'];
        $this->game = $team['game'];
        $this->club_id = $team['club_id'];
    }

    public function getName(int $id) : string{
        $this->getById($id);
        return $this->name;
    }

    public function getGame(int $id) : string{
        $this->getById($id);
        return $this->game;
    }

    public function getClubId(int $id) : int{
        $this->getById($id);
        return $this->club_id;
    }

    //save team in database
    public function save(string $name, string $game, int $club_id): bool
    {
        $sql = "INSERT INTO team (name, game, club_id) VALUES(?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$name, $game, $club_id]);
    }

    //delete team from database
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM team WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //update team from database
    public function update(string $name, string $game, int $id): bool
    {
        $sql = "UPDATE team SET name = ?, game = ?, WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$name, $game, $id]);
    }
}