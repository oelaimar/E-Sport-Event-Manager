CREATE TABLE IF NOT EXISTS
    club (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        city VARCHAR(50) NOT NULL,
        created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE IF NOT EXISTS
    team (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        game VARCHAR(50) NOT NULL,
        club_id INT NOT NULL,
        FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE TABLE IF NOT EXISTS
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
        format VARCHAR(50),
        total_cashprize DECIMAL(12, 2),
        tournament_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
    );

CREATE TABLE IF NOT EXISTS
    matches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tournament_id INT NOT NULL,
        team_1_id INT NOT NULL,
        team_2_id INT NOT NULL,
        score_team_1 INT DEFAULT 0,
        score_team_2 INT DEFAULT 0,
        winner_team_id INT,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE,
        FOREIGN KEY (team_1_id) REFERENCES team (id),
        FOREIGN KEY (team_2_id) REFERENCES team (id),
        FOREIGN KEY (winner_team_id) REFERENCES team (id),
        CHECK (team_1_id <> team_2_id)
    );

CREATE TABLE IF NOT EXISTS
    sponsor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    );

CREATE TABLE IF NOT EXISTS
    sponsor_tournament (
        sponsor_id INT NOT NULL,
        tournament_id INT NOT NULL,
        contribution DECIMAL(12, 2) NOT NULL,
        PRIMARY KEY (sponsor_id, tournament_id),
        FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE,
        FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE
    );