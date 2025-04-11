<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spel extends Model
{
    use HasFactory;

    public function reservering()
    {
        return $this->hasOne(Reservering::class);
    }

    public function uitslagen()
    {
        return $this->hasMany(UitslagOverzicht::class);
    }
}