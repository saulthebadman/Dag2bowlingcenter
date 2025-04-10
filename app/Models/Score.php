<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
}

// database/migrations/xxxx_xx_xx_create_scores_table.php
public function up()
public function speler()
{
    return $this->belongsTo(Speler::class);
}


{
    Schema::create('scores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('player_id')->constrained()->onDelete('cascade');
        $table->integer('value');
        $table->string('mode');
        $table->timestamp('scored_at');
        $table->timestamps();
    });
}
