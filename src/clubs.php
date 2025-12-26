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

    public function getName(int $id): string
    {
        $this->getById($id);
        return $this->name;
    }

    public function getCity(int $id): string
    {
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

    public function getAllWithStats(): array
    {
        $sql = "SELECT club.id, club.name, club.city, count(team.id) as team_total FROM club 
                LEFT JOIN team on club.id = team.club_id
                GROUP BY club.id;";

        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }
}

function manageClubs() : void
{
    $clubObject = new Clubs;
    $allClubs = $clubObject->getAllData();

    while (true) {
        Console::clear();
        Console::write("=== WELCOME TO VERSUS MANAGER ===\n", "yellow");
        Console::write("\n\tManage Clubs\n", "cyan");
        echo "\t1. Create A New Club\n";
        echo "\t2. Display All Clubs\n";
        echo "\t3. Delete A Club\n";
        echo "\t4. Update A Club\n";
        echo "\t5. See The Clubs With Number Of Teams\n";
        Console::write("\t0. Return\n", "red");

        $choice = Console::read((string)Console::write("\tSelect A Choice", "magenta"));

        switch ($choice) {
            case '1':
                $name = Console::read("\tname of club");
                $city = Console::read("\tcity");

                if ($clubObject->save($name, $city)) {
                    Console::write("\n\tthe club is saves !\n", "green");
                }else{
                    Console::write("\n\tthere is a problem !\n", "red");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '2':
                Console::write("\n--- CLUBS LISTE ---\n", "yellow");
                foreach ($allClubs as $club) {
                    echo "-{$club['id']} {$club['name']} ({$club['city']})\n";
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '3':
                Console::write("\n--- DELETE CLUBS ---\n", "yellow");
                foreach ($allClubs as $club) {
                    echo "-{$club['id']} {$club['name']} ({$club['city']})\n";
                }
                $id = Console::read((string)Console::write("\tSelect The Id Of The Club You Want To Delete", "magenta"));
                if ($clubObject->delete((int)$id)) {
                    Console::write("\n\tthe club is deleted !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't delete this club !\n", "red");
                }
                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '4':
                Console::write("\n--- UPDATE THE CLUBS ---\n", "yellow");
                foreach ($allClubs as $club) {
                    echo "-{$club['id']} {$club['name']} ({$club['city']})\n";
                }

                $id   = Console::read((string)Console::write("\tSelect The Id Of The Club You Want To Update", "magenta"));
                $name = Console::read("\tthe new name of club");
                $city = Console::read("\tcity");

                if ($clubObject->update($name, $city, (int)$id)) {
                    Console::write("\n\tthe club is updated !\n", "green");
                } else {
                    Console::write("\n\tthere is a problem you can't updated this club !\n", "red");
                }

                Console::read((string)Console::write("\t=== CLICK ENTER TO CONTUNUE ===", "blue"));
                break;
            case '5':
                $stats = $clubObject->getAllWithStats();
                Console::write("\n--- CLUBS LISTE WITH TEAMS ---\n", "yellow");
                // var_dump($stats);
                foreach ($stats as $row) {
                    echo "- {$row['name']} ({$row['city']}) | NUMBER OF TEAMS : {$row['team_total']}\n";
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
