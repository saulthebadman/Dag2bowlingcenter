-- Gebruik juiste database
USE bowlingcenter;

-- Verwijder eerst bestaande tabellen
DROP TABLE IF EXISTS reserveringen;
DROP TABLE IF EXISTS klanten;
DROP TABLE IF EXISTS banen;

-- Tabel: klanten
CREATE TABLE klanten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    telefoonnummer VARCHAR(20)
);

-- Tabel: banen
CREATE TABLE banen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nummer VARCHAR(10) UNIQUE NOT NULL, -- Uniek nummer voor elke baan
    max_personen INT NOT NULL DEFAULT 10, -- Maximum aantal personen per baan
    is_kinderbaan BOOLEAN DEFAULT FALSE, -- Kinderbaan of niet
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel: reserveringen
CREATE TABLE reserveringen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserveringsnummer VARCHAR(20) UNIQUE,
    klant_id INT NOT NULL,
    baan_id INT NOT NULL,
    datum DATE NOT NULL,
    tijd TIME NOT NULL,
    aantal_personen INT NOT NULL,
    opmerking TEXT,
    tarief DECIMAL(8,2) NOT NULL,
    opties JSON NULL,
    betaling_op_locatie BOOLEAN DEFAULT FALSE,
    magic_bowlen BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (klant_id) REFERENCES klanten(id),
    FOREIGN KEY (baan_id) REFERENCES banen(id)
);

-- Drop procedures
DROP PROCEDURE IF EXISTS SP_GetReserveringen;
DROP PROCEDURE IF EXISTS SP_InsertReservering;
DROP PROCEDURE IF EXISTS SP_UpdateReservering;

DELIMITER //

-- SP: ophalen reserveringen
CREATE PROCEDURE SP_GetReserveringen()
BEGIN
    SELECT 
        R.id,
        R.reserveringsnummer,
        K.naam AS klant_naam,
        K.telefoonnummer,
        B.nummer AS baan_nummer,
        R.datum,
        R.tijd,
        R.aantal_personen,
        R.opmerking,
        R.tarief,
        R.opties,
        R.betaling_op_locatie,
        R.magic_bowlen,
        R.created_at,
        R.updated_at
    FROM reserveringen AS R
    INNER JOIN klanten AS K ON R.klant_id = K.id
    INNER JOIN banen AS B ON R.baan_id = B.id;
END //

-- SP: insert reservering
CREATE PROCEDURE SP_InsertReservering(
    IN p_klant_naam VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_baan_id INT,
    IN p_datum DATE,
    IN p_tijd TIME,
    IN p_aantal_personen INT,
    IN p_opmerking TEXT,
    IN p_tarief DECIMAL(8,2),
    IN p_opties JSON,
    IN p_betaling_op_locatie BOOLEAN,
    IN p_magic_bowlen BOOLEAN
)
BEGIN
    DECLARE klant_id INT;
    DECLARE new_reserveringsnummer VARCHAR(20);
    DECLARE new_reservering_id INT;

    -- Klant zoeken of toevoegen
    SELECT id INTO klant_id
    FROM klanten
    WHERE naam = p_klant_naam AND telefoonnummer = p_telefoonnummer
    LIMIT 1;

    IF klant_id IS NULL THEN
        INSERT INTO klanten (naam, telefoonnummer)
        VALUES (p_klant_naam, p_telefoonnummer);
        SET klant_id = LAST_INSERT_ID();
    END IF;

    -- Genereer reserveringsnummer
    REPEAT
        SET new_reserveringsnummer = CONCAT('RSV-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(FLOOR(RAND() * 999 + 1), 3, '0'));
    UNTIL NOT EXISTS (SELECT 1 FROM reserveringen WHERE reserveringsnummer = new_reserveringsnummer) END REPEAT;

    -- Insert reservering
    INSERT INTO reserveringen (
        klant_id,
        baan_id,
        datum,
        tijd,
        aantal_personen,
        opmerking,
        tarief,
        opties,
        betaling_op_locatie,
        magic_bowlen,
        reserveringsnummer
    )
    VALUES (
        klant_id,
        p_baan_id,
        p_datum,
        p_tijd,
        p_aantal_personen,
        p_opmerking,
        p_tarief,
        p_opties,
        p_betaling_op_locatie,
        p_magic_bowlen,
        new_reserveringsnummer
    );

    SET new_reservering_id = LAST_INSERT_ID();

    -- Retourneer ingevoegde reservering
    SELECT 
        R.id,
        R.reserveringsnummer,
        K.naam AS klant_naam,
        K.telefoonnummer,
        B.nummer AS baan_nummer,
        R.datum,
        R.tijd,
        R.aantal_personen,
        R.opmerking,
        R.tarief,
        R.opties,
        R.betaling_op_locatie,
        R.magic_bowlen,
        R.created_at,
        R.updated_at
    FROM reserveringen R
    INNER JOIN klanten K ON R.klant_id = K.id
    INNER JOIN banen B ON R.baan_id = B.id
    WHERE R.id = new_reservering_id;
END //

-- SP: update reservering
CREATE PROCEDURE SP_UpdateReservering(
    IN p_id INT,
    IN p_klant_id INT,
    IN p_baan_id INT,
    IN p_datum DATE,
    IN p_tijd TIME,
    IN p_aantal_personen INT,
    IN p_opmerking TEXT,
    IN p_tarief DECIMAL(8,2),
    IN p_opties JSON,
    IN p_betaling_op_locatie BOOLEAN,
    IN p_magic_bowlen BOOLEAN
)
BEGIN
    -- Update uitvoeren
    UPDATE reserveringen
    SET 
        klant_id = p_klant_id,
        baan_id = p_baan_id,
        datum = p_datum,
        tijd = p_tijd,
        aantal_personen = p_aantal_personen,
        opmerking = p_opmerking,
        tarief = p_tarief,
        opties = p_opties,
        betaling_op_locatie = p_betaling_op_locatie,
        magic_bowlen = p_magic_bowlen,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_id;

    -- Retourneer geüpdatete reservering
    SELECT 
        R.id,
        R.reserveringsnummer,
        K.naam AS klant_naam,
        K.telefoonnummer,
        B.nummer AS baan_nummer,
        R.datum,
        R.tijd,
        R.aantal_personen,
        R.opmerking,
        R.tarief,
        R.opties,
        R.betaling_op_locatie,
        R.magic_bowlen,
        R.created_at,
        R.updated_at
    FROM reserveringen R
    INNER JOIN klanten K ON R.klant_id = K.id
    INNER JOIN banen B ON R.baan_id = B.id
    WHERE R.id = p_id;
END //

DELIMITER //

-- Voeg testdata toe voor banen
INSERT INTO banen (nummer, max_personen, is_kinderbaan) VALUES
('1', 10, false),
('2', 10, false),
('3', 10, true),
('4', 10, true),
('5', 10, false),
('6', 10, false);