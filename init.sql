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

-- =====================
-- CLUBS
-- =====================
INSERT INTO club (name, city) VALUES
('Atlas Esports', 'Casablanca'),
('Rabat Wolves', 'Rabat'),
('Marrakech Kings', 'Marrakech');

-- =====================
-- TEAMS
-- =====================
INSERT INTO team (name, game, club_id) VALUES
('Atlas CS', 'Counter-Strike', 1),
('Atlas Valorant', 'Valorant', 1),
('Wolves CS', 'Counter-Strike', 2),
('Kings CS', 'Counter-Strike', 3);

-- =====================
-- PLAYERS
-- =====================
INSERT INTO player (nickname, role, salary, team_id) VALUES
('Ace', 'Sniper', 2500.00, 1),
('Shadow', 'Entry Fragger', 2200.00, 1),
('Blaze', 'Support', 2000.00, 1),

('Viper', 'Duelist', 2400.00, 2),
('Nova', 'Controller', 2100.00, 2),

('WolfX', 'AWPer', 2300.00, 3),
('Fang', 'Rifler', 2100.00, 3),

('KingZ', 'IGL', 2600.00, 4),
('Crown', 'Support', 1900.00, 4);

-- =====================
-- TOURNAMENTS
-- format = 2 / 4 / 8 / 16
-- =====================
INSERT INTO tournament (title, format, total_cashprize, status) VALUES
('Morocco CS Duel', 2, 5000.00, 'upcoming'),
('Rabat CS Cup', 4, 12000.00, 'ongoing'),
('Atlas Championship', 8, 30000.00, 'finished'),
('National Esports League', 16, 100000.00, 'upcoming');

-- =====================
-- MATCHES
-- =====================
INSERT INTO matches (
    tournament_id,
    team_1_id,
    team_2_id,
    score_team_1,
    score_team_2,
    winner_team_id
) VALUES
(2, 1, 3, 16, 12, 1),
(2, 2, 4, 10, 16, 4),

(3, 1, 4, 14, 16, 4),
(3, 3, 2, 16, 8, 3);

-- =====================
-- SPONSORS
-- =====================
INSERT INTO sponsor (name, contribution) VALUES
('Red Bull', 25000.00),
('Intel', 40000.00),
('HyperX', 15000.00);

-- =====================
-- SPONSOR ↔ TOURNAMENT
-- =====================
INSERT INTO sponsor_tournament (sponsor_id, tournament_id, contribution) VALUES
(1, 2, 8000.00),
(2, 3, 20000.00),
(3, 3, 10000.00),
(2, 4, 40000.00);
