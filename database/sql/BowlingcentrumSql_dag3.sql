CREATE DATABASE Bowlingcentrum;

USE Bowlingcentrum;

CREATE TABLE spellen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL
);

CREATE TABLE personen (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL
);

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

DELIMITER $$

CREATE PROCEDURE GetUitslagen()
BEGIN
    SELECT u.id, s.naam AS spel, p.naam AS persoon, u.aantal_punten
    FROM uitslagoverzicht u
    JOIN spellen s ON u.spel_id = s.id
    JOIN personen p ON u.persoon_id = p.id;
END$$

DELIMITER ;
