<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('uitslagoverzicht', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spel_id');
            $table->unsignedBigInteger('persoon_id');
            $table->integer('aantal_punten');
            $table->timestamps();

            $table->foreign('spel_id')->references('id')->on('spellen')->onDelete('cascade');
            $table->foreign('persoon_id')->references('id')->on('personen')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uitslagoverzicht');
    }
};
