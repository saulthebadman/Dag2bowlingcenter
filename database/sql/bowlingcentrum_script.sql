-- Maak de database
CREATE DATABASE IF NOT EXISTS bowlingcentrumdag03;
USE bowlingcentrumdag03;

-- Verwijder bestaande tabellen als ze al bestaan
DROP TABLE IF EXISTS uitslag;
DROP TABLE IF EXISTS spel;
DROP TABLE IF EXISTS reservering;
DROP TABLE IF EXISTS persoon;

-- Tabel: persoon
CREATE TABLE IF NOT EXISTS persoon (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type_persoon VARCHAR(50) NOT NULL,
    voornaam VARCHAR(255) NOT NULL,
    tussenvoegsel VARCHAR(50) DEFAULT NULL,
    achternaam VARCHAR(255) NOT NULL,
    roepnaam VARCHAR(255) NOT NULL,
    is_volwassen BOOLEAN NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabel: reservering
CREATE TABLE IF NOT EXISTS reservering (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    persoon_id BIGINT UNSIGNED NOT NULL,
    openingstijd_id INT NOT NULL,
    baan_id INT NOT NULL,
    pakket_optie_id INT DEFAULT NULL,
    reservering_status VARCHAR(50) NOT NULL,
    reserveringsnummer VARCHAR(50) NOT NULL,
    datum DATE NOT NULL,
    aantal_uren INT NOT NULL,
    begintijd TIME NOT NULL,
    eindtijd TIME NOT NULL,
    aantal_volwassenen INT DEFAULT NULL,
    aantal_kinderen INT DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (persoon_id) REFERENCES persoon(id) ON DELETE CASCADE
);

-- Tabel: spel
CREATE TABLE IF NOT EXISTS spel (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    persoon_id BIGINT UNSIGNED NOT NULL,
    reservering_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (persoon_id) REFERENCES persoon(id) ON DELETE CASCADE,
    FOREIGN KEY (reservering_id) REFERENCES reservering(id) ON DELETE CASCADE
);

-- Tabel: uitslag
CREATE TABLE IF NOT EXISTS uitslag (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    spel_id BIGINT UNSIGNED NOT NULL,
    aantal_punten INT DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (spel_id) REFERENCES spel(id) ON DELETE CASCADE
);

-- Voeg voorbeeldgegevens toe aan persoon
INSERT INTO persoon (type_persoon, voornaam, tussenvoegsel, achternaam, roepnaam, is_volwassen, created_at, updated_at) VALUES
('Klant', 'Mazin', NULL, 'Jamil', 'Mazin', 1, NOW(), NOW()),
('Klant', 'Arjan', 'de', 'Ruijter', 'Arjan', 1, NOW(), NOW()),
('Klant', 'Hans', NULL, 'Odijk', 'Hans', 1, NOW(), NOW()),
('Klant', 'Dennis', 'van', 'Wakeren', 'Dennis', 1, NOW(), NOW()),
('Medewerker', 'Wilco', 'Van de', 'Grift', 'Wilco', 1, NOW(), NOW()),
('Gast', 'Tom', NULL, 'Sanders', 'Tom', 0, NOW(), NOW()),
('Gast', 'Andrew', NULL, 'Sanders', 'Andrew', 0, NOW(), NOW()),
('Gast', 'Julian', NULL, 'Kaldenheuvel', 'Julian', 1, NOW(), NOW());

-- Voeg voorbeeldgegevens toe aan reservering
INSERT INTO reservering (persoon_id, openingstijd_id, baan_id, pakket_optie_id, reservering_status, reserveringsnummer, datum, aantal_uren, begintijd, eindtijd, aantal_volwassenen, aantal_kinderen, created_at, updated_at) VALUES
(1, 2, 8, 1, 'Bevestigd', '2022122000001', '2022-12-20', 1, '15:00', '16:00', 4, 2, NOW(), NOW()),
(2, 2, 2, 3, 'Bevestigd', '2022122000002', '2022-12-20', 1, '17:00', '18:00', 4, NULL, NOW(), NOW()),
(3, 7, 3, 1, 'Bevestigd', '2022122400003', '2022-12-24', 2, '16:00', '18:00', 4, NULL, NOW(), NOW()),
(1, 2, 6, NULL, 'Bevestigd', '2022122700004', '2022-12-27', 2, '17:00', '19:00', 2, NULL, NOW(), NOW()),
(4, 3, 4, 4, 'Bevestigd', '2022122800005', '2022-12-28', 1, '14:00', '15:00', 3, NULL, NOW(), NOW()),
(5, 10, 5, 4, 'Bevestigd', '2022122800006', '2022-12-28', 2, '19:00', '21:00', 2, NULL, NOW(), NOW()),
-- Reservering zonder gekoppelde spellen of uitslagen (voor het testen van het unhappy path)
(6, 1, 1, NULL, 'Bevestigd', '2022123000007', '2022-12-30', 2, '14:00', '16:00', 2, 1, NOW(), NOW());

-- Voeg voorbeeldgegevens toe aan spel
INSERT INTO spel (persoon_id, reservering_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW()),
(2, 2, NOW(), NOW()),
(3, 3, NOW(), NOW()),
(4, 5, NOW(), NOW()),
(6, 5, NOW(), NOW()),
(7, 5, NOW(), NOW()),
(8, 5, NOW(), NOW());

-- Voeg voorbeeldgegevens toe aan uitslag
INSERT INTO uitslag (spel_id, aantal_punten, created_at, updated_at) VALUES
(1, 290, NOW(), NOW()),
(2, 300, NOW(), NOW()),
(3, 120, NOW(), NOW()),
(4, 34, NOW(), NOW()),
(5, NULL, NOW(), NOW()),
(6, 234, NOW(), NOW()),
(7, 299, NOW(), NOW());

-- Verwijder bestaande stored procedures als deze al bestaan
DROP PROCEDURE IF EXISTS GetUitslagen;
DROP PROCEDURE IF EXISTS GetReserveringen;

-- Stored Procedure: Haal uitslagen op met INNER JOIN
DELIMITER $$

CREATE PROCEDURE GetUitslagen()
BEGIN
    SELECT 
        u.id AS uitslag_id,
        p.voornaam AS persoon_voornaam,
        p.achternaam AS persoon_achternaam,
        s.id AS spel_id,
        u.aantal_punten
    FROM uitslag u
    INNER JOIN spel s ON u.spel_id = s.id
    INNER JOIN persoon p ON s.persoon_id = p.id
    ORDER BY u.aantal_punten DESC;
END$$

-- Stored Procedure: Haal reserveringen op met INNER JOIN
CREATE PROCEDURE GetReserveringen()
BEGIN
    SELECT 
        r.id AS reservering_id,
        p.voornaam AS persoon_voornaam,
        p.achternaam AS persoon_achternaam,
        r.reserveringsnummer,
        r.datum,
        r.begintijd,
        r.eindtijd,
        r.aantal_volwassenen,
        r.aantal_kinderen
    FROM reservering r
    INNER JOIN persoon p ON r.persoon_id = p.id
    ORDER BY r.datum, r.begintijd;
END$$

DELIMITER ;

-- Roep de stored procedures aan
CALL GetUitslagen();
CALL GetReserveringen();
