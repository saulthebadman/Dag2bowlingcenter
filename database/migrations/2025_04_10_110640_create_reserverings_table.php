<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

        public function up()
        {
            Schema::create('reserveringen', function (Blueprint $table) {
                $table->id();
                $table->foreignId('klant_id')->constrained('klanten');
                $table->foreignId('baan_id')->constrained('banen');
                $table->date('datum');
                $table->time('tijd');
                $table->integer('aantal_personen');
                $table->text('opmerking')->nullable();
                $table->timestamps();
            });
        }
        
    public function down(): void
    {
        Schema::dropIfExists('reserveringen');
    }
};
