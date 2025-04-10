<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservering extends Model
{
    protected $table = 'reserveringen';

    protected $fillable = [
        'reserveringsnummer',
        'klant_id',
        'baan_id',
        'datum',
        'tijd',
        'aantal_personen',
        'opmerking',
    ];
}
