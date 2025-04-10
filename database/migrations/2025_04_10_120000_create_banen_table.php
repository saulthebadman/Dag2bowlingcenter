<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('banen', function (Blueprint $table) {
            $table->id();
            $table->string('nummer')->unique(); // Uniek nummer voor elke baan
            $table->boolean('is_kinderbaan')->default(false); // Kinderbaan of niet
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banen');
    }
};
