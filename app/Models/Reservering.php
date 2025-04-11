<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservering extends Model
{
    use HasFactory;

    protected $fillable = ['tijd', 'aantal_personen', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

