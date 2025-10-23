<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->float('avg_satisfaction')->default(0)->after('logo');
            $table->integer('events_sponsored_count')->default(0)->after('avg_satisfaction');
            $table->decimal('total_contribution', 15, 2)->default(0)->after('events_sponsored_count');
            $table->float('impact_score')->default(0)->after('total_contribution');
            $table->enum('performance_level', ['Top Performer', 'Potentiel élevé', 'À relancer'])
                ->default('À relancer')->after('impact_score');
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn([
                'avg_satisfaction',
                'events_sponsored_count',
                'total_contribution',
                'impact_score',
                'performance_level'
            ]);
        });
    }
};
