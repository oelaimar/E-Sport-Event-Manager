<?php
require_once "database.php";
require_once "teams.php";
require_once "matches.php";

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
        $sql = "SELECT * FROM tournament WHERE id = ?";
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

    public function getFormat(int $id): int
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
        int $format,
        float $total_cashprize,
        string $status
    ): bool {
        $sql = "INSERT INTO tournament (title, format, total_cashprize, status) VALUES (?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$title, $format, $total_cashprize, $status]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tournament WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(
        string $title,
        int $format,
        string $status,
        int $id
    ): bool {
        $sql = "UPDATE matches SET title = ? , format = ? , status = ? WHERE id = ?;";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$title, $format, $status, $id]);
    }
}

function manageTournament(): void
{
    $tournamentsObject = new Tournaments;
    $teamsObject = new Teams;
    $matchesObject = new Matches;

    while (true) {
        $allTeams = $teamsObject->getAllData();
        $alltournaments = $tournamentsObject->getAllData();

        Console::clear();
        Console::write("=== WELCOME TO VERSUS MANAGER ===\n", "yellow");
        Console::write("\n\tManage Tournaments\n", "cyan");
        echo "\t1. Create A New Tournaments\n";
        echo "\t2. Start A Tournaments\n";
        echo "\t3. Display All Tournaments\n";
        echo "\t4. Delete A Tournaments\n";
        echo "\t5. Update A Tournaments\n";
        Console::write("\t0. Return\n", "red");

        $choice = Console::read((string)Console::write("\tSelect A Choice", "magenta"));

        switch ($choice) {
            case '1':
                $title = Console::read("\ttitle of tournaments");
                echo "\t1. Round of 16\n";
                echo "\t2. Round of 8\n";
                echo "\t3. Round of 4\n";
                echo "\t4. Round of 2\n";
                $formatChoice = Console::read("\tchose format");
                switch ($formatChoice) {
                    case 1:
                        $format = 16;
                        break;
                    case 2:
                        $format = 8;
                        break;
                    case 3:
                        $format = 4;
                        break;
                    case 4:
                        $format = 2;
                        break;
                }
                //i use $input to change the data type to float
                $input = trim(Console::read("\thow much cashprize this tournemant needs"));
                $total_cashprize = (float)$input;
                $status = "upcoming";
                if ($tournamentsObject->save($title, $format, (float)$total_cashprize, $status)) {
                    Console::write("\n\tthe club is saves !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem !\n", "red");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '2':
                Console::write("\n--- START A TOURNEMANT ---\n", "yellow");
                Console::write("\n--- LIST OF UPCOMING TOURNEMANT ---\n", "yellow");
                foreach ($alltournaments as $tournament) {
                    if ($tournament['status'] == "upcoming")
                        echo "-{$tournament['id']} {$tournament['title']}\n";
                }
                $tournamentid = Console::read("\tchoose the id of the tournament");

                Console::write("\n--- TEAMS LISTE ---\n", "yellow");
                foreach ($allTeams as $team) {
                    echo "-{$team['id']} {$team['name']} | {$team['game']} | club: ({$team['club_name']})\n";
                }

                $format = $tournamentsObject->getFormat($tournamentid);
                $teamsIdsParticipants = [];

                while ($format > 0) {
                    echo "need to add {$format} \n";
                    $teamId = Console::read("\tchoose teams by id");
                    if (!in_array($teamId, $teamsIdsParticipants)) {
                        $teamsIdsParticipants[] = $teamId;
                        $format--;
                    } else {
                        Console::write("this team was chossen\n", "red");
                    }
                }
                shuffle($teamsIdsParticipants);

                generateRandomMaches($teamsIdsParticipants, $tournamentid, $matchesObject, $teamsObject);

                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '3':
                Console::write("\n--- LIST TOURNEMANT ---\n", "yellow");
                foreach ($alltournaments as $tournament) {
                    echo "-{$tournament['id']} {$tournament['title']}\n";
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            // case '4':
            //     Console::write("\n--- UPDATE THE CLUBS ---\n", "yellow");
            //     foreach ($allClubs as $club) {
            //         echo "-{$club['id']} {$club['name']} ({$club['city']})\n";
            //     }

            //     $id   = Console::read((string)Console::write("\tSelect The Id Of The Club You Want To Update", "magenta"));
            //     $name = Console::read("\tthe new name of club");
            //     $city = Console::read("\tcity");

            //     if ($clubObject->update($name, $city, (int)$id)) {
            //         Console::write("\n\tthe club is updated !\n", "green");
            //     } else {
            //         Console::write("\n\tthere is a problem you can't updated this club !\n", "red");
            //     }

            //     Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
            //     break;
            // case '5':
            //     $stats = $clubObject->getAllWithStats();
            //     Console::write("\n--- CLUBS LISTE WITH TEAMS ---\n", "yellow");
            //     // var_dump($stats);
            //     foreach ($stats as $row) {
            //         echo "- {$row['name']} ({$row['city']}) | NUMBER OF TEAMS : {$row['team_total']}\n";
            //     }
            //     Console::read((string)Console::write("=== CLICK ENTER TO CONTUNUE ===", "blue"));
            //     break;

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


function generateRandomMaches(array $teams, int $tournamentid, Matches $matchesObject, Teams $teamsObject)
{
    $newTeams = [];
    if (count($teams) > 1) {

        for ($i = 0; $i < count($teams); $i += 2) {
            $score_team_1 = random_int(0, 100);
            $score_team_2 = random_int(0, 100);

            $winnerId = $score_team_1 > $score_team_2 ? $teams[$i] : $teams[$i + 1];

            $matchesObject->save($tournamentid, $teams[$i], $teams[$i + 1], $score_team_1, $score_team_2, $winnerId);

            Console::write("{$teamsObject->getName($teams[$i])}", $teams[$i] === $winnerId ? "green" : "red");
            Console::write(" vs ", "magenta");
            Console::write("{$teamsObject->getName($teams[$i + 1])}", $teams[$i + 1] === $winnerId ? "green" : "red");
            Console::write(" | ", "yallow");
            $newTeams[] = $winnerId;
        }
        Console::write("\n");
        return generateRandomMaches($newTeams, $tournamentid, $matchesObject, $teamsObject);
    } else {
        return false;
    }
}