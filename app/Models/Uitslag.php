<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uitslag extends Model
{
    use HasFactory;

    protected $table = 'uitslag';

    protected $fillable = ['spel_id', 'aantal_punten'];

    public function spel()
    {
        return $this->belongsTo(Spel::class);
    }

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'persoon_id');
    }
}
