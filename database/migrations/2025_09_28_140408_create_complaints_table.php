<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('complaints', function (Blueprint $table) {
            $table->id('idComplaint');
            $table->string('type');
            $table->text('description');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->string('reply')->nullable();
            $table->dateTime('created_at');
            $table->string('severity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
