<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UitslagOverzicht extends Model
{
    use HasFactory;

    protected $table = 'uitslagoverzicht'; // Zorg ervoor dat de tabelnaam correct is

    protected $fillable = ['spel_id', 'persoon_id', 'aantal_punten'];

    public function spel()
    {
        return $this->belongsTo(Spel::class);
    }

    public function persoon()
    {
        return $this->belongsTo(Persoon::class);
    }
}
