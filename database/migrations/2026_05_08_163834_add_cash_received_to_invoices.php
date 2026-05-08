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
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'cash_received')) {
                $table->decimal('cash_received', 10, 2)->nullable()->after('payable_amount');
            }
            if (!Schema::hasColumn('invoices', 'change_returned')) {
                $table->decimal('change_returned', 10, 2)->nullable()->after('payable_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'cash_received')) {
                $table->dropColumn('cash_received');
            }
            if (Schema::hasColumn('invoices', 'change_returned')) {
                $table->dropColumn('change_returned');
            }
        });
    }
};
