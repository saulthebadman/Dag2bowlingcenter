DROP PROCEDURE IF EXISTS SP_InsertReservering;

DELIMITER //

CREATE PROCEDURE SP_InsertReservering(
    IN p_klant_naam VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_datum DATE,
    IN p_tijd TIME,
    IN p_aantal_personen INT,
    IN p_opmerking TEXT,
    IN p_tarief DECIMAL(8,2),
    IN p_betaling_op_locatie BOOLEAN
)
BEGIN
    DECLARE klant_id INT;

    -- Zoek of voeg klant toe
    SELECT id INTO klant_id
    FROM klanten
    WHERE naam = p_klant_naam AND telefoonnummer = p_telefoonnummer
    LIMIT 1;

    IF klant_id IS NULL THEN
        INSERT INTO klanten (naam, telefoonnummer)
        VALUES (p_klant_naam, p_telefoonnummer);
        SET klant_id = LAST_INSERT_ID();
    END IF;

    -- Voeg reservering toe
    INSERT INTO reserveringen (
        klant_id,
        datum,
        tijd,
        aantal_personen,
        opmerking,
        tarief,
        betaling_op_locatie,
        reserveringsnummer
    )
    VALUES (
        klant_id,
        p_datum,
        p_tijd,
        p_aantal_personen,
        p_opmerking,
        p_tarief,
        p_betaling_op_locatie,
        CONCAT('RSV-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD(FLOOR(RAND() * 999 + 1), 3, '0'))
    );
END //

DELIMITER ;
