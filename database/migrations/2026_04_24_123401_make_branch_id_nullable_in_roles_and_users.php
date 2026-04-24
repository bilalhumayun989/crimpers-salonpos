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
        Schema::table('staff_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable(false)->change();
        });
    }
};
