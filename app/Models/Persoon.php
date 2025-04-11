<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persoon extends Model
{
    use HasFactory;

    // Specificeer de juiste tabelnaam
    protected $table = 'persoon'; // Aangepaste tabelnaam

    protected $fillable = ['naam'];

    public function reserveringen()
    {
        return $this->hasMany(Reservering::class);
    }
}
