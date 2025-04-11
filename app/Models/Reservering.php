<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservering extends Model
{
    use HasFactory;

    // Specificeer de juiste tabelnaam
    protected $table = 'reservering';

    protected $fillable = [
        'persoon_id',
        'datum',
        'aantal_uren',
        'begintijd',
        'eindtijd',
        'aantal_volwassenen',
        'aantal_kinderen',
    ];

    public function persoon()
    {
        return $this->belongsTo(Persoon::class);
    }

    public function spellen()
    {
        return $this->hasMany(Spel::class);
    }
}
