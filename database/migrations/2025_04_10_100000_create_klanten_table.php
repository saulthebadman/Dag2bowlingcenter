<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klanten', function (Blueprint $table) {
            $table->id(); // Primairy key
            $table->string('naam');
            $table->string('telefoonnummer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klanten');
    }
};
