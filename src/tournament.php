<?php
require_once "database.php";

class Tournaments extends Database
{
    private int $id;
    private string $title, $format, $tournament_date;
    private float $total_cashprize;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM tournament;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id): void
    {
        $sql = "SELECT * FROM matches WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $tournament = $stmt->fetch();

        $this->id = (int)$tournament['id'];
        $this->title = (int)$tournament['title'];
        $this->format = (int)$tournament['format'];
        $this->tournament_date = (int)$tournament['tournament_date'];
        $this->total_cashprize = (int)$tournament['total_cashprize'];
    }

    public function getTitle(int $id): string
    {
        $this->getById($id);
        return $this->title;
    }

    public function getFormat(int $id): string
    {
        $this->getById($id);
        return $this->format;
    }

    public function getTournamentDate(int $id): string
    {
        $this->getById($id);
        return $this->tournament_date;
    }

    public function gettToalCashprize(int $id): string
    {
        $this->getById($id);
        return $this->total_cashprize;
    }

    public function save(
        string $title,
        string $format,
        string $tournament_date,
        string $total_cashprize
    ): bool {
        $sql = "INSERT INTO tournament (title, format, tournament_date, total_cashprize) VALUES (?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$title, $format, $tournament_date, $total_cashprize]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tournament WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

     public function update(
        string $title,
        string $format,
        string $tournament_date,
        int $id
    ): bool {
        $sql = "UPDATE matches SET title = ? , format = ? , tournament_date = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$title, $format, $tournament_date, $id]);
    }

}
