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
            $table->text('pricing_levels')->nullable()->change();
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->text('pricing_levels')->nullable()->change();
        });

        Schema::table('staff_roles', function (Blueprint $table) {
            $table->text('permissions')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('pricing_levels')->nullable()->change();
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->json('pricing_levels')->nullable()->change();
        });

        Schema::table('staff_roles', function (Blueprint $table) {
            $table->json('permissions')->nullable()->change();
        });
    }
};
