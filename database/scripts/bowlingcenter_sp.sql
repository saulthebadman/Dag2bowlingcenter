USE laravel;

-- Verwijder bestaande procedures als ze al bestaan
DROP PROCEDURE IF EXISTS SP_GetAllReserveringen;
DROP PROCEDURE IF EXISTS SP_CreateReservering;
DROP PROCEDURE IF EXISTS SP_UpdateReservering;

DELIMITER $$

-- Ophalen van alle reserveringen
CREATE PROCEDURE SP_GetAllReserveringen()
BEGIN
    SELECT * FROM reserveringen;
END $$

-- Toevoegen van een nieuwe reservering
CREATE PROCEDURE SP_CreateReservering(
    IN p_naam VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_datum DATE,
    IN p_tijd TIME,
    IN p_opmerkingen TEXT
)
BEGIN
    INSERT INTO reserveringen (naam, email, telefoonnummer, datum, tijd, opmerkingen, created_at, updated_at)
    VALUES (p_naam, p_email, p_telefoonnummer, p_datum, p_tijd, p_opmerkingen, NOW(), NOW());
END $$

-- Bewerken van een bestaande reservering
CREATE PROCEDURE SP_UpdateReservering(
    IN p_id INT,
    IN p_naam VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_datum DATE,
    IN p_tijd TIME,
    IN p_opmerkingen TEXT
)
BEGIN
    UPDATE reserveringen
    SET naam = p_naam,
        email = p_email,
        telefoonnummer = p_telefoonnummer,
        datum = p_datum,
        tijd = p_tijd,
        opmerkingen = p_opmerkingen,
        updated_at = NOW()
    WHERE id = p_id;
END $$

DELIMITER ;
