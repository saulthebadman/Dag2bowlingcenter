<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uitslag extends Model
{
    use HasFactory;

    protected $table = 'uitslag'; // Aangepaste tabelnaam

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
