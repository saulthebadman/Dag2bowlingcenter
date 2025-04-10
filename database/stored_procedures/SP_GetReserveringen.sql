DELIMITER //

CREATE PROCEDURE SP_GetReserveringen()
BEGIN
    SELECT 
        R.id,
        R.reserveringsnummer, -- Zorg ervoor dat deze kolom wordt geselecteerd
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

DELIMITER ;
