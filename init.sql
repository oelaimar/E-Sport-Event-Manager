CREATE TABLE
    club (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        city VARCHAR(50) NOT NULL,
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE
    team (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        game VARCHAR(50) NOT NULL,
        club_id INT NOT NULL,
        FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE
    player (
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
        format INT,
        total_cashprize DECIMAL(12, 2),
        status VARCHAR(20),
        tournament_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE
    matches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tournament_id INT NOT NULL,
        team_1_id INT NULL,
        team_2_id INT NULL,
        score_team_1 INT DEFAULT 0,
        score_team_2 INT DEFAULT 0,
        winner_team_id INT NULL,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE,
        FOREIGN KEY (team_1_id) REFERENCES team (id) ON DELETE SET NULL ON UPDATE CASCADE,
        FOREIGN KEY (team_2_id) REFERENCES team (id) ON DELETE SET NULL ON UPDATE CASCADE,
        FOREIGN KEY (winner_team_id) REFERENCES team (id) ON DELETE SET NULL ON UPDATE CASCADE
    );

CREATE TABLE
    sponsor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        contribution DECIMAL(12, 2) NOT NULL
    );

CREATE TABLE
    sponsor_tournament (
        sponsor_id INT NOT NULL,
        tournament_id INT NOT NULL,
        contribution DECIMAL(12, 2) NOT NULL,
        PRIMARY KEY (sponsor_id, tournament_id),
        FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE
    );

-- =========================
-- CLUBS (required by team)
-- =========================
INSERT INTO club (id, name, city) VALUES
(1, 'Atlas Esports', 'Casablanca'),
(2, 'Rabat Kings', 'Rabat'),
(3, 'Marrakech Wolves', 'Marrakech'),
(4, 'Tanger Titans', 'Tanger'),
(5, 'Fes Dragons', 'Fes');

-- =========================
-- TEAMS
-- =========================
INSERT INTO team (id, name, game, club_id) VALUES
(1, 'Atlas CS', 'CS2', 1),
(2, 'Atlas Valorant', 'Valorant', 1),
(3, 'Rabat CS', 'CS2', 2),
(4, 'Rabat LOL', 'League of Legends', 2),
(5, 'Wolves CS', 'CS2', 3),
(6, 'Wolves Dota', 'Dota 2', 3),
(7, 'Titans Valorant', 'Valorant', 4),
(8, 'Dragons CS', 'CS2', 5);

-- =========================
-- PLAYERS
-- =========================
INSERT INTO player (nickname, role, salary, team_id) VALUES
('Ace', 'AWPer', 2500.00, 1),
('Flash', 'Entry Fragger', 2200.00, 1),
('Smoke', 'Support', 2000.00, 1),
('Viper', 'IGL', 2600.00, 1),

('Phoenix', 'Duelist', 2300.00, 2),
('Shadow', 'Controller', 2100.00, 2),
('Hunter', 'Initiator', 2150.00, 2),

('Lion', 'AWPer', 2400.00, 3),
('Storm', 'Rifler', 2100.00, 3),
('Wall', 'Support', 1900.00, 3),

('King', 'Top', 2000.00, 4),
('Mage', 'Mid', 2200.00, 4),
('Arrow', 'ADC', 2100.00, 4),
('Shield', 'Support', 1800.00, 4),

('Wolf', 'Carry', 2600.00, 6),
('Fang', 'Mid', 2400.00, 6),
('Tank', 'Offlane', 2300.00, 6),

('Spark', 'Duelist', 2250.00, 7),
('Ice', 'Sentinel', 2050.00, 7),

('Dragon', 'AWPer', 2550.00, 8),
('Scale', 'Support', 1950.00, 8);

-- =========================
-- TOURNAMENTS
-- =========================
INSERT INTO tournament (id, title, format, total_cashprize, status) VALUES
(1, 'Morocco CS Championship', 16, 50000.00, 'upcoming'),
(2, 'North Africa Valorant Cup', 8, 30000.00, 'upcoming'),
(3, 'Arab League Invitational', 12, 75000.00, 'finished');

-- =========================
-- MATCHES
-- =========================
INSERT INTO matches (tournament_id, team_1_id, team_2_id, score_team_1, score_team_2, winner_team_id) VALUES
(1, 1, 3, 16, 12, 1),
(1, 5, 8, 14, 16, 8),
(1, 1, 8, 16, 10, 1),

(2, 2, 7, 13, 9, 2),
(2, 7, 2, 11, 13, 2),

(3, 3, 5, 2, 1, 3),
(3, 4, 6, 0, 2, 6);

-- =========================
-- SPONSORS
-- =========================
INSERT INTO sponsor (id, name, contribution) VALUES
(1, 'Red Bull', 30000.00),
(2, 'Intel', 25000.00),
(3, 'NVIDIA', 40000.00),
(4, 'Logitech', 20000.00);

-- =========================
-- SPONSOR ↔ TOURNAMENT
-- =========================
INSERT INTO sponsor_tournament (sponsor_id, tournament_id, contribution) VALUES
(1, 1, 15000.00),
(2, 1, 10000.00),
(4, 1, 5000.00),

(3, 3, 30000.00),
(1, 3, 20000.00),

(2, 2, 15000.00),
(4, 2, 8000.00);

