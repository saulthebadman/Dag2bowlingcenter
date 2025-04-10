<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('reserveringen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->nullable()->constrained('klanten')->onDelete('cascade');
            $table->string('reserveringsnummer')->unique();
            $table->date('datum');
            $table->time('tijd');
            $table->integer('aantal_personen');
            $table->text('opmerking')->nullable();
            $table->decimal('tarief', 8, 2);
            $table->json('opties')->nullable();
            $table->boolean('betaling_op_locatie')->default(false); // Voeg een kolom toe voor betaling op locatie
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserveringen');
    }
};
