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
        Schema::table('service_packages', function (Blueprint $table) {
            $table->json('pricing_levels')->nullable()->after('price');
            $table->boolean('peak_pricing_enabled')->default(false)->after('pricing_levels');
            $table->decimal('peak_price', 10, 2)->nullable()->after('peak_pricing_enabled');
            $table->time('peak_start')->nullable()->after('peak_price');
            $table->time('peak_end')->nullable()->after('peak_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_packages', function (Blueprint $table) {
            $table->dropColumn(['pricing_levels', 'peak_pricing_enabled', 'peak_price', 'peak_start', 'peak_end']);
        });
    }
};
