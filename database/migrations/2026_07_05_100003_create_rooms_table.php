<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->string('room_number')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity')->default(2); // max guests
            $table->integer('beds')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->integer('floor')->default(1);
            $table->decimal('size_sqm', 8, 2)->nullable(); // room size
            $table->boolean('has_wifi')->default(true);
            $table->boolean('has_aircon')->default(true);
            $table->boolean('has_tv')->default(true);
            $table->boolean('has_minibar')->default(false);
            $table->boolean('breakfast_included')->default(false);
            $table->string('view')->nullable(); // garden, pool, city
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
