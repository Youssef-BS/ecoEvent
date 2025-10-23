<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('total_contribution');
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->decimal('total_contribution', 15, 2)->default(0)->after('events_sponsored_count');
        });
    }
};
