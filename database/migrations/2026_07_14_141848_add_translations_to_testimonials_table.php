<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Add JSON columns for multi-language support
            $table->json('content_translations')->nullable()->after('content');
            $table->json('guest_name_translations')->nullable()->after('guest_name');
            $table->json('guest_location_translations')->nullable()->after('guest_location');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['content_translations', 'guest_name_translations', 'guest_location_translations']);
        });
    }
};
