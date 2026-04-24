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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('pricing_levels_enabled')->default(false)->after('price');
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->boolean('pricing_levels_enabled')->default(false)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('pricing_levels_enabled');
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->dropColumn('pricing_levels_enabled');
        });
    }
};
