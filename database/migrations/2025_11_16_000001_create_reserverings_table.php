m<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reserveringen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persoon_id');
            $table->date('datum');
            $table->integer('aantal_uren');
            $table->time('begintijd');
            $table->time('eindtijd');
            $table->integer('aantal_volwassenen');
            $table->integer('aantal_kinderen');
            $table->timestamps();

            $table->foreign('persoon_id')->references('id')->on('personen')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserveringen');
    }
};
