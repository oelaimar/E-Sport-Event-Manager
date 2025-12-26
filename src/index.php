<?php
require_once "console.php";
require_once "clubs.php";
require_once "teams.php";
require_once "players.php";
require_once "matches.php";
require_once "sponsors.php";
require_once "tournament.php";
require_once "sponsor_tournament.php";

while (true) {
    Console::clear();
    Console::write("=== WELCOME TO VERSUS MANAGER ===\n", "yellow");
    Console::write("\n\tMENU PRINCIPAL\n", "cyan");
    echo "\t1. Manage Clubs\n";
    echo "\t2. Manage Teams\n";
    echo "\t3. Manage Players\n";
    echo "\t4. Manage Tournament\n";
    echo "\t5. See The Statistic\n";
    Console::write("\t0. exit\n", "red");

    $choice = Console::read((string)Console::write("\tSelect A Choice", "magenta"));

    switch ($choice) {
        case '1':
            manageClubs();
            break;
        case '2':
            manageTeams();
            break;
        case '3':
            managePlayers();
            break;
        case '4':
            break;
        case '4':
            break;
        case '0':
            Console::write("Exiting...\n", "red");
            exit;
        default:
            Console::write("\tOption invalide.\n", "red");
            break;
    }
}
