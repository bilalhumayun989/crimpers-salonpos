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
        Schema::table('staff', function (Blueprint $table) {
            $table->decimal('hourly_rate', 60, 2)->default(0)->change();
            $table->decimal('base_salary', 60, 2)->default(0)->change();
            $table->decimal('commission_per_service', 60, 2)->default(0)->change();
            $table->decimal('commission_per_customer', 60, 2)->default(0)->change();
            $table->decimal('total_earned_commission', 60, 2)->default(0)->change();
            $table->integer('rating_total')->default(0)->change();
            $table->integer('rating_count')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // No easy way to revert 'default' without knowing previous state, 
            // but we can just leave them as they are or set to null if they were null.
        });
    }
};
