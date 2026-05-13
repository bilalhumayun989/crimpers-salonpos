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
        // Restore defaults for all tables affected by the precision increase migration

        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price', 60, 2)->default(0)->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('total_amount', 60, 2)->default(0)->change();
            $table->decimal('tax', 60, 2)->default(0)->change();
            $table->decimal('discount', 60, 2)->default(0)->change();
            $table->decimal('payable_amount', 60, 2)->default(0)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('selling_price', 60, 2)->default(0)->change();
        });

        Schema::table('cash_reconciliations', function (Blueprint $table) {
            $table->decimal('opening_balance', 60, 2)->default(0)->change();
            $table->decimal('expected_cash', 60, 2)->default(0)->change();
            $table->decimal('actual_cash', 60, 2)->default(0)->change();
            $table->decimal('difference', 60, 2)->default(0)->change();
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->decimal('price', 60, 2)->default(0)->change();
            $table->decimal('subtotal', 60, 2)->default(0)->change();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->decimal('prepaid_credit', 60, 2)->default(0)->change();
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->decimal('price', 60, 2)->default(0)->change();
        });

        Schema::table('upsell_performances', function (Blueprint $table) {
            $table->decimal('upsell_revenue', 60, 2)->default(0)->change();
            $table->decimal('average_upsell_value', 60, 2)->default(0)->change();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->decimal('total_amount', 60, 2)->default(0)->change();
        });

        Schema::table('purchase_items', function (Blueprint $table) {
            $table->decimal('unit_cost', 60, 2)->default(0)->change();
            $table->decimal('line_total', 60, 2)->default(0)->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('amount', 60, 2)->default(0)->change();
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('value', 60, 2)->default(0)->change();
            $table->decimal('minimum_purchase', 60, 2)->default(0)->change();
        });

        Schema::table('gift_cards', function (Blueprint $table) {
            $table->decimal('initial_balance', 60, 2)->default(0)->change();
            $table->decimal('current_balance', 60, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No simple reversal
    }
};
