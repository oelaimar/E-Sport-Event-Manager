<?php
require_once "database.php";

class Matches extends Database
{
    private int $id, $tournament_id, $team_1_id, $team_2_id, $score_team_1, $score_team_2, $winner_team_id;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT * FROM matches;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): void
    {
        $sql = "SELECT * FROM matches WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $match = $stmt->fetch();

        $this->id = (int)$match['id'];
        $this->tournament_id = (int)$match['tournament_id'];
        $this->team_1_id = (int)$match['team_1_id'];
        $this->team_2_id = (int)$match['team_2_id'];
        $this->score_team_1 = (int)$match['score_team_1'];
        $this->score_team_2 = (int)$match['score_team_2'];
        $this->winner_team_id = (int)$match['winner_team_id'];
    }

    public function getTournamentId(int $id): int
    {
        $this->getById($id);
        return $this->tournament_id;
    }

    public function getTeam1Id(int $id): int
    {
        $this->getById($id);
        return $this->team_1_id;
    }

    public function getTeam2Id(int $id): int
    {
        $this->getById($id);
        return $this->team_2_id;
    }

    public function getScoreTeam1(int $id): int
    {
        $this->getById($id);
        return $this->score_team_1;
    }

    public function getScoreTeam2(int $id): int
    {
        $this->getById($id);
        return $this->score_team_2;
    }

    public function getWinnerTeamId(int $id): int
    {
        $this->getById($id);
        return $this->winner_team_id;
    }

    public function save(
        int $tournament_id,
        int $team_1_id,
        int $team_2_id,
        int $score_team_1,
        int $score_team_2,
        int $winner_team_id
    ): bool {
        $sql = "INSERT INTO matches (tournament_id, team_1_id, team_2_id, score_team_1, score_team_2, winner_team_id) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$tournament_id, $team_1_id, $team_2_id, $score_team_1, $score_team_2, $winner_team_id]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM matches WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(
        int $score_team_1,
        int $score_team_2,
        int $winner_team_id,
        int $id
    ): bool {
        $sql = "UPDATE matches SET score_team_1 = ? , score_team_2 = ? , winner_team_id = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$score_team_1, $score_team_2, $winner_team_id, $id]);
    }
}
