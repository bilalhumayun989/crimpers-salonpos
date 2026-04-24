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
            $table->decimal('base_salary', 12, 2)->default(0)->after('hourly_rate');
            $table->decimal('commission_per_service', 10, 2)->default(0)->after('base_salary');
            $table->decimal('total_earned_commission', 12, 2)->default(0)->after('commission_per_service');
            $table->integer('rating_total')->default(0)->after('rating');
            $table->integer('rating_count')->default(0)->after('rating_total');
            $table->string('current_shift')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['base_salary', 'commission_per_service', 'total_earned_commission', 'rating_total', 'rating_count', 'current_shift']);
        });
    }
};
