<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spel extends Model
{
    use HasFactory;

    protected $table = 'spel'; // Aangepaste tabelnaam

    protected $fillable = ['persoon_id', 'reservering_id'];

    public function reservering()
    {
        return $this->belongsTo(Reservering::class);
    }

    public function uitslagen()
    {
        return $this->hasMany(Uitslag::class);
    }
}