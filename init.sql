CREATE TABLE
    IF NOT EXISTS club (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        city VARCHAR(50) NOT NULL,
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS team (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        game VARCHAR(50) NOT NULL,
        club_id INT NOT NULL,
        FOREIGN KEY (club_id) REFERENCES club (id) O\CADE
    );

CREATE TABLE
    IF NOT EXISTS player (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nickname VARCHAR(50) NOT NULL UNIQUE,
        role VARCHAR(50),
        salary DECIMAL(10, 2),
        team_id INT NOT NULL,
        FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    tournament (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(120) NOT NULL,
        format VARCHAR(50),
        total_cashprize DECIMAL(12, 2),
        tournament_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS matches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tournament_id INT NOT NULL,
        team_1_id INT NOT NULL,
        team_2_id INT NOT NULL,
        score_team_1 INT DEFAULT 0,
        score_team_2 INT DEFAULT 0,
        winner_team_id INT,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE,
        FOREIGN KEY (team_1_id) REFERENCES team (id) ON DELETE SET NULL,
        FOREIGN KEY (team_2_id) REFERENCES team (id) ON DELETE SET NULL,
        FOREIGN KEY (winner_team_id) REFERENCES team (id) ON DELETE SET NULL,
        CHECK (team_1_id <> team_2_id)
    );

CREATE TABLE
    IF NOT EXISTS sponsor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS sponsor_tournament (
        sponsor_id INT NOT NULL,
        tournament_id INT NOT NULL,
        contribution DECIMAL(12, 2) NOT NULL,
        PRIMARY KEY (sponsor_id, tournament_id),
        FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE
    );

/* ===============================
CLUB
=============================== */
INSERT INTO
    club (name, city)
VALUES
    ('Atlas Lions', 'Casablanca'),
    ('Rabat Warriors', 'Rabat'),
    ('Marrakech Phoenix', 'Marrakech'),
    ('Tangier Storm', 'Tangier'),
    ('Agadir Sharks', 'Agadir');

/* ===============================
TEAM
=============================== */
INSERT INTO
    team (name, game, club_id)
VALUES
    ('Atlas CS', 'Counter-Strike', 1),
    ('Atlas Valorant', 'Valorant', 1),
    ('Rabat CS', 'Counter-Strike', 2),
    ('Rabat LOL', 'League of Legends', 2),
    ('Phoenix Dota', 'Dota 2', 3),
    ('Phoenix CS', 'Counter-Strike', 3),
    ('Storm Valorant', 'Valorant', 4),
    ('Storm LOL', 'League of Legends', 4),
    ('Sharks Dota', 'Dota 2', 5),
    ('Sharks CS', 'Counter-Strike', 5);

/* ===============================
PLAYER
=============================== */
INSERT INTO
    player (nickname, role, salary, team_id)
VALUES
    ('AtlasSniper', 'AWPer', 3200.00, 1),
    ('AtlasEntry', 'Entry', 2800.00, 1),
    ('AtlasIGL', 'IGL', 3500.00, 1),
    ('AtlasSupport', 'Support', 2600.00, 1),
    ('AtlasLurk', 'Lurker', 2900.00, 1),
    ('AtlasViper', 'Controller', 3000.00, 2),
    ('AtlasJett', 'Duelist', 3400.00, 2),
    ('AtlasSova', 'Initiator', 3100.00, 2),
    ('AtlasKilljoy', 'Sentinel', 2900.00, 2),
    ('AtlasFlex', 'Flex', 2800.00, 2),
    ('RabatAce', 'AWPer', 3300.00, 3),
    ('RabatEntry', 'Entry', 2900.00, 3),
    ('RabatIGL', 'IGL', 3600.00, 3),
    ('RabatSupport', 'Support', 2700.00, 3),
    ('RabatLurk', 'Lurker', 3000.00, 3),
    ('RabatTop', 'Top', 3100.00, 4),
    ('RabatJungle', 'Jungle', 3200.00, 4),
    ('RabatMid', 'Mid', 3400.00, 4),
    ('RabatADC', 'ADC', 3300.00, 4),
    ('RabatSupportLOL', 'Support', 3000.00, 4),
    ('PhoenixCarry', 'Carry', 3500.00, 5),
    ('PhoenixMid', 'Mid', 3400.00, 5),
    ('PhoenixOfflane', 'Offlane', 3200.00, 5),
    ('PhoenixSupport1', 'Support', 2800.00, 5),
    ('PhoenixSupport2', 'Support', 2800.00, 5),
    ('PhoenixSniper', 'AWPer', 3300.00, 6),
    ('PhoenixEntry', 'Entry', 3000.00, 6),
    ('PhoenixIGL', 'IGL', 3600.00, 6),
    ('PhoenixSupport', 'Support', 2700.00, 6),
    ('PhoenixLurk', 'Lurker', 2950.00, 6),
    ('StormJett', 'Duelist', 3450.00, 7),
    ('StormSova', 'Initiator', 3150.00, 7),
    ('StormOmen', 'Controller', 3050.00, 7),
    ('StormKilljoy', 'Sentinel', 2900.00, 7),
    ('StormFlex', 'Flex', 2800.00, 7),
    ('StormTop', 'Top', 3000.00, 8),
    ('StormJungle', 'Jungle', 3150.00, 8),
    ('StormMid', 'Mid', 3350.00, 8),
    ('StormADC', 'ADC', 3250.00, 8),
    ('StormSupportLOL', 'Support', 2950.00, 8),
    ('SharkCarry', 'Carry', 3400.00, 9),
    ('SharkMid', 'Mid', 3300.00, 9),
    ('SharkOfflane', 'Offlane', 3100.00, 9),
    ('SharkSupport1', 'Support', 2750.00, 9),
    ('SharkSupport2', 'Support', 2750.00, 9),
    ('SharkSniper', 'AWPer', 3250.00, 10),
    ('SharkEntry', 'Entry', 2950.00, 10),
    ('SharkIGL', 'IGL', 3550.00, 10),
    ('SharkSupport', 'Support', 2650.00, 10),
    ('SharkLurk', 'Lurker', 2900.00, 10);

/* ===============================
TOURNAMENT
=============================== */
INSERT INTO
    tournament (title, format, total_cashprize)
VALUES
    ('Morocco Esports Cup', 'LAN', 50000.00),
    ('North Africa Masters', 'Online', 75000.00),
    ('Casablanca Invitational', 'LAN', 30000.00),
    ('Rabat Championship', 'LAN', 45000.00);

/* ===============================
MATCHES
=============================== */
INSERT INTO
    matches (
        tournament_id,
        team_1_id,
        team_2_id,
        score_team_1,
        score_team_2,
        winner_team_id
    )
VALUES
    (1, 1, 3, 16, 12, 1),
    (1, 2, 7, 13, 16, 7),
    (1, 6, 10, 16, 14, 6),
    (2, 4, 8, 2, 1, 4),
    (2, 5, 9, 2, 0, 5),
    (3, 1, 6, 14, 16, 6),
    (3, 3, 10, 16, 8, 3),
    (4, 2, 7, 16, 11, 2),
    (4, 4, 8, 3, 2, 4);

/* ===============================
SPONSOR
=============================== */
INSERT INTO
    sponsor (name)
VALUES
    ('Red Bull'),
    ('Intel'),
    ('NVIDIA'),
    ('HyperX'),
    ('Razer');

/* ===============================
SPONSOR_TOURNAMENT
=============================== */
INSERT INTO
    sponsor_tournament (sponsor_id, tournament_id, contribution)
VALUES
    (1, 1, 15000.00),
    (2, 1, 20000.00),
    (3, 2, 25000.00),
    (4, 3, 10000.00),
    (5, 4, 12000.00),
    (1, 2, 18000.00),
    (2, 3, 15000.00),
    (3, 4, 20000.00);