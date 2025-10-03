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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2); // Change from integer to decimal
        $table->integer('quantity')->default(1);
        $table->timestamps(); // Add timestamps if missing
    });
}

    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('store_id')->nullable();
        $table->dropForeign(['event_id']);
        $table->dropColumn(['event_id','name','description','price','quantity']);
    });
}
};
