-- Maak de database
CREATE DATABASE IF NOT EXISTS bowlingcentrumdag03;
USE bowlingcentrumdag03;

-- Verwijder bestaande tabellen als ze al bestaan
DROP TABLE IF EXISTS uitslagoverzicht;
DROP TABLE IF EXISTS spellen;
DROP TABLE IF EXISTS personen;

-- Tabel: spellen
CREATE TABLE spellen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabel: personen
CREATE TABLE personen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabel: uitslagoverzicht
CREATE TABLE uitslagoverzicht (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    spel_id BIGINT UNSIGNED NOT NULL,
    persoon_id BIGINT UNSIGNED NOT NULL,
    aantal_punten INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (spel_id) REFERENCES spellen(id) ON DELETE CASCADE,
    FOREIGN KEY (persoon_id) REFERENCES personen(id) ON DELETE CASCADE
);

-- Voeg voorbeeldgegevens toe aan spellen
INSERT INTO spellen (naam, created_at, updated_at) VALUES
('Bowling Game 1', NOW(), NOW()),
('Bowling Game 2', NOW(), NOW());

-- Voeg voorbeeldgegevens toe aan personen
INSERT INTO personen (naam, created_at, updated_at) VALUES
('John Doe', NOW(), NOW()),
('Jane Smith', NOW(), NOW()),
('Alice Johnson', NOW(), NOW());

-- Voeg voorbeeldgegevens toe aan uitslagoverzicht
INSERT INTO uitslagoverzicht (spel_id, persoon_id, aantal_punten, created_at, updated_at) VALUES
(1, 1, 150, NOW(), NOW()),
(1, 2, 200, NOW(), NOW()),
(2, 3, 180, NOW(), NOW());

-- Verwijder bestaande stored procedure als deze al bestaat
DROP PROCEDURE IF EXISTS GetUitslagen;

-- Stored Procedure: Haal uitslagen op met INNER JOIN
DELIMITER $$

CREATE PROCEDURE GetUitslagen()
BEGIN
    SELECT 
        u.id AS uitslag_id,
        p.naam AS persoon_naam,
        s.naam AS spel_naam,
        u.aantal_punten
    FROM uitslagoverzicht u
    INNER JOIN personen p ON u.persoon_id = p.id
    INNER JOIN spellen s ON u.spel_id = s.id
    ORDER BY u.aantal_punten DESC;
END$$

DELIMITER ;

-- Roep de stored procedure aan
CALL GetUitslagen();
