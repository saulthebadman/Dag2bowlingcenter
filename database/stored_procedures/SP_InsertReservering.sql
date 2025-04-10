DROP PROCEDURE IF EXISTS SP_InsertReservering;

DELIMITER //

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
END //

DELIMITER ;
