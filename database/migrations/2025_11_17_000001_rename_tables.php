<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('personen', 'persoon');
        Schema::rename('reserveringen', 'reservering');
        Schema::rename('spellen', 'spel');
        Schema::rename('uitslagoverzicht', 'uitslag');
    }

    public function down(): void
    {
        Schema::rename('persoon', 'personen');
        Schema::rename('reservering', 'reserveringen');
        Schema::rename('spel', 'spellen');
        Schema::rename('uitslag', 'uitslagoverzicht');
    }
};
