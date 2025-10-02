<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messageries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamp('sent_at');
            $table->string('status')->default('Sent');
            $table->timestamps();

            $table->index(['sender_id', 'receiver_id']);
            $table->index(['receiver_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messageries');
    }
};
