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
        $tables = [
            'staff_attendances', 'cash_reconciliations', 'coupons', 
            'discount_rules', 'leave_requests', 'staff_shifts', 'categories'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'branch_id')) {
                        $table->foreignId('branch_id')->default(1)->constrained('branches')->onDelete('cascade');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'staff_attendances', 'cash_reconciliations', 'coupons', 
            'discount_rules', 'leave_requests', 'staff_shifts', 'categories'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'branch_id')) {
                        $table->dropForeign([ 'branch_id' ]);
                        $table->dropColumn('branch_id');
                    }
                });
            }
        }
    }
};
