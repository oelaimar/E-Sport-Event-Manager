<?php
require_once "./database.php";
require_once "./clubs.php";

class Teams extends Database
{
    private ?int $id;
    private string $name, $game;
    private int $club_id;

    //return an arr you shoud affict it to a variable
    public function getAllData(): array
    {
        $sql = "SELECT team.*, club.name AS club_name FROM team JOIN club on team.club_id = club.id ORDER BY team.id;";
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

    public function getName(int $id): string
    {
        $this->getById($id);
        return $this->name;
    }

    public function getGame(int $id): string
    {
        $this->getById($id);
        return $this->game;
    }

    public function getClubId(int $id): int
    {
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

    public function getAllWithStats(): array
    {
        $sql = "SELECT t1.id , t1.name , t2.name as team_2 , t_winner.name AS winner, m.score_team_1, m.score_team_2
                FROM team t1
                JOIN matches m
                ON t1.id = m.team_1_id or t1.id = m.team_2_id
                JOIN team t2 
                ON t2.id <> m.team_1_id or t2.id <> m.team_2_id
                JOIN team t_winner
                ON t_winner.id = m.winner_team_id or t_winner.id = m.winner_team_id
                ORDER BY t1.id;";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }
}

function manageTeams()
{
    $teamObject = new Teams;
    $clubObject = new Clubs;

    $allTeams = $teamObject->getAllData();
    $allClubs = $clubObject->getAllData();


    while (true) {
        Console::clear();
        Console::write("=== WELCOME TO VERSUS MANAGER ===\n", "yellow");
        Console::write("\n\tManage Teams\n", "cyan");
        echo "\t1. Create A New Team\n";
        echo "\t2. Display All Teams\n";
        echo "\t3. Delete A Team\n";
        echo "\t4. Update A Team\n";
        echo "\t5. See The Teams With Maches\n";
        Console::write("\t0. Return\n", "red");

        $choice = Console::read((string)Console::write("\tSelect A Choice", "magenta"));

        switch ($choice) {
            case '1':
                $name = Console::read("\tname of team");
                $game = Console::read("\tthe game");

                Console::write("\n--- CLUBS LISTE ---\n", "yellow");
                foreach ($allClubs as $club) {
                    echo "-{$club['id']} {$club['name']} ({$club['city']})\n";
                }
                $clubId = Console::read("\tSelect the club for this team by ID");

                if ($teamObject->save($name, $game, $clubId)) {
                    Console::write("\n\tthe club is saves !\n", "green");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '2':
                Console::write("\n--- TEAMS LISTE ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']} | {$team['game']} | club: ({$team['club_name']})\n";
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '3':
                Console::write("\n--- DELETE TEAM ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']}\n";
                }
                $id = Console::read((string)Console::write("\tSelect The Id Of The Team You Want To Delete", "magenta"));
                if ($clubObject->delete((int)$id)) {
                    Console::write("\n\tthe team is deleted !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't delete this team !\n", "red");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '4':
                Console::write("\n--- UPDATE THE TEAM ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']}\n";
                }

                $id   = Console::read((string)Console::write("\tSelect The Id Of The Team You Want To Update", "magenta"));
                $name = Console::read("\tthe new name o team");
                $game = Console::read("\tthe game");

                if ($teamObject->update($name, $game, $id)) {
                    Console::write("\n\tthe club is updated !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't updated this club !\n", "red");
                }

                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '5':
                $stats = $teamObject->getAllWithStats();
                Console::write("\n--- TEAMS LISTE ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']}\n";
                }
                $id = Console::read("\tSelect the team you want to see the stats by ID");
                Console::write("\n--- THE STATS OF TEAM ---\n", "yellow");
                foreach ($allTeams as $team) {
                    if ($team['id'] == $id) {
                        Console::write("-{$team['name']}\n", "cyan");
                    }
                }
                $count = 0;
                foreach ($stats as $row) {
                    if ($row['id'] == $id) {
                        $count++;
                        Console::write("- Match " ). Console::write("{$count} ", "magenta") . Console::write("vs {$row['team_2']} | score : {$row['score_team_1']} | {$row['score_team_2']} | THE WINNER : ") . Console::write("{$row['winner']}\n" , "magenta");
                    }
                }
                Console::read((string)Console::write("=== CLICK ENTER TO CONTUNUE ===", "blue"));
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
