<?php
require_once "./database.php";
require_once "./teams.php";

class Players extends Database
{
    private ?int $id;
    private string $nickname, $role;
    private float $salary;
    private int $team_id;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT p.*, t.name AS team_name FROM player p join team t on t.id = p.team_id ORDER BY p.id;";
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

    //save player in database
    public function save(string $nickname, string $role, float $salary, int $team_id): bool
    {
        $sql = "INSERT INTO player (nickname, role, salary, team_id) VALUES(?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);

        return $stmt->execute([$nickname, $role, $salary, $team_id]);
    }

    //delete player from database
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM player WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    //update player from database
    public function update(string $nickname, string $role, float $salary, int $id): bool
    {
        $sql = "UPDATE player SET nickname = ?, role = ?, salary = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$nickname, $role, $salary, $id]);
    }
}

function managePlayers(): void
{
    $teamObject = new Teams;
    $playerObject = new Players;
    
    while (true) {
        $allTeams = $teamObject->getAllData();
        $allPlayers = $playerObject->getAllData();
        
        Console::clear();
        Console::write("=== WELCOME TO VERSUS MANAGER ===\n", "yellow");
        Console::write("\n\tManage Teams\n", "cyan");
        echo "\t1. Add A New Player\n";
        echo "\t2. Display All Players\n";
        echo "\t3. Delete A Player\n";
        echo "\t4. Update A Player\n";
        Console::write("\t0. Return\n", "red");

        $choice = Console::read((string)Console::write("\tSelect A Choice", "magenta"));

        switch ($choice) {
            case '1':
                $nickname = Console::read("\tthe player's nickname");
                $role = Console::read("\tthe role");
                $salary = Console::read("\tthe salary");

                Console::write("\n--- TEAMS LISTE ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']} | {$team['game']} | club: ({$team['club_name']})\n";
                }
                
                $taemId = Console::read("\tSelect the team for this player by ID");

                if ($playerObject->save($nickname, $role, $salary, $taemId)) {
                    Console::write("\n\tthe club is saves !\n", "green");
                }else{
                    Console::write("\n\tthere is a problem !\n", "red");
                }

                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '2':
                Console::write("\n--- PLAYERS LISTE ---\n", "yellow");
                foreach ($allPlayers as $player) {
                    echo "-{$player['id']} {$player['nickname']} | {$player['role']} | {$player['salary']} | team: ({$player['team_name']})\n";
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '3':
                Console::write("\n--- DELETE PLAYER ---\n", "yellow");
                foreach ($allPlayers as $player) {
                    echo "-{$player['id']} {$player['nickname']}\n";
                }
                $id = Console::read((string)Console::write("\tSelect The Id Of The Player You Want To Delete", "magenta"));
                if ($playerObject->delete((int)$id)) {
                    Console::write("\n\tthe team is deleted !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't delete this team !\n", "red");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '4':
                Console::write("\n--- UPDATE THE PLAYER ---\n", "yellow");
                foreach ($allPlayers as $player) {
                    echo "-{$player['id']} {$player['nickname']}\n";
                }

                $id   = Console::read((string)Console::write("\tSelect The Id Of The Player You Want To Update", "magenta"));
                $nickname = Console::read("\tthe player's nickname");
                $role = Console::read("\tthe role");
                $salary = Console::read("\tthe salary");

                if ($playerObject->update($nickname, $role, $salary, $id)) {
                    Console::write("\n\tthe player is updated !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't updated this player !\n", "red");
                }

                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '0':
                Console::write("Exiting...\n", "red");
                Console::read((string)Console::write("=== CLICK ENTER TO CONTUNUE ===", "blue"));
                return;

            default:
                Console::write("Option invalide.\n", "red");
                Console::read((string)Console::write("=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
        }
    }
}
