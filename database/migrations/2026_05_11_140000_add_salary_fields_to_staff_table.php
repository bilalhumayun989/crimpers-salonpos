<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'base_salary')) {
                $table->decimal('base_salary', 10, 2)->default(0)->after('hourly_rate');
            }
            if (!Schema::hasColumn('staff', 'commission_per_customer')) {
                $table->decimal('commission_per_customer', 8, 2)->default(0)->after('base_salary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumnIfExists('base_salary');
            $table->dropColumnIfExists('commission_per_customer');
        });
    }
};
