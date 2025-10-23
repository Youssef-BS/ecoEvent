<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsor_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // note 1 à 5
            $table->text('comment')->nullable();
            $table->timestamps();

            // On ne met plus l'unique key
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
