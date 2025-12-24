<?php
require_once "./database.php";

class Players extends Database
{
    private ?int $id;
    private string $nickname, $role;
    private float $salary;
    private int $team_id;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM player;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id): void
    {
        $sql = "SELECT * FROM player WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $player = $stmt->fetch();

        $this->id = (int)$player['id'];
        $this->nickname = $player['nickname'];
        $this->role = $player['role'];
        $this->salary = (float)$player['salary'];
        $this->team_id = (int)$player['team_id'];
    }

    public function getNickname(int $id): string
    {
        $this->getById($id);
        return $this->nickname;
    }

    public function getRole(int $id): string
    {
        $this->getById($id);
        return $this->role;
    }

    public function getSalary(int $id): float
    {
        $this->getById($id);
        return $this->salary;
    }

    public function getTeamId(int $id): int
    {
        $this->getById($id);
        return $this->team_id;
    }

    //save club in database
    public function save(string $nickname, string $role, float $salary, int $team_id): bool
    {
        $sql = "INSERT INTO player (nickname, role, salary, team_id) VALUES(?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$nickname, $role, $salary, $team_id]);
    }

    //delete club from database
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM player WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //update club from database
    public function update(string $nickname, string $role, float $salary, int $id): bool
    {
        $sql = "UPDATE player SET nickname = ?, role = ?, salary = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$nickname, $role, $salary, $id]);
    }
}
