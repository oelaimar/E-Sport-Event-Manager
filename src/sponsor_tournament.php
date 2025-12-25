<?php
require_once "database.php";

enum EntityType: string
{
    case SPONSOR = 'sponsore';
    case TOURNAMENT = 'tournament';
}

class SponsorTournament extends Database
{
    private int $sponsor_id, $tournament_id;
    private float $contribution;

    public function getAllData(): array
    {
        $sql = "SELECT * FROM sponsor_tournament;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    private function getById(int $id, EntityType $type): void
    {
        if ($type == EntityType::SPONSOR) {
            $sql = "SELECT * FROM sponsor_tournament WHERE sponsor_id = ?;";
        }
        if ($type == EntityType::TOURNAMENT) {
            $sql = "SELECT * FROM sponsor_tournament WHERE tournament_id = ?;";
        }
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $sponsor_tournament = $stmt->fetch();

        $this->sponsor_id = (int)$sponsor_tournament['sponsor_id'];
        $this->tournament_id = $sponsor_tournament['tournament_id'];
        $this->contribution = $sponsor_tournament['contribution'];
    }

    public function getSponsorId(int $id, EntityType $type): string
    {
        $this->getById($id, $type);
        return $this->sponsor_id;
    }

    public function getTournamentId(int $id, EntityType $type): string
    {
        $this->getById($id, $type);
        return $this->tournament_id;
    }

    public function getContribution(int $id, EntityType $type): string
    {
        $this->getById($id, $type);
        return $this->contribution;
    }

    public function save(string $sponsor_id, string $tournament_id, float $contribution): bool
    {
        $sql = "INSERT INTO sponsor_tournament (sponsor_id, tournament_id, contribution) VALUES(?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$sponsor_id, $tournament_id, $contribution]);
    }

    public function delete(int $id, EntityType $type): bool
    {
        if ($type == EntityType::SPONSOR) {
            $sql = "DELETE FROM sponsor_tournament WHERE sponsor_id = ?;";
        }
        if ($type == EntityType::TOURNAMENT) {
            $sql = "DELETE FROM sponsor_tournament WHERE tournament_id = ?;";
        }
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(string $sponsor_id, string $tournament_id, float $contribution, int $id, EntityType $type): bool
    {
        if ($type == EntityType::SPONSOR) {
            $sql = "UPDATE sponsor_tournament SET sponsor_id = ? , tournament_id = ?, contribution = ? WHERE sponsor_id = ?;";
        }
        if ($type == EntityType::TOURNAMENT) {
            $sql = "UPDATE sponsor_tournament SET sponsor_id = ? , tournament_id = ?, contribution = ? WHERE tournament_id = ?;";
        }
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$sponsor_id, $tournament_id, $contribution, $id]);
    }
}
