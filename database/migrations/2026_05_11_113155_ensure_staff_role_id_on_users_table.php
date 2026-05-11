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
        if (!Schema::hasColumn('users', 'staff_role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('staff_role_id')->nullable()->after('role');
                $table->foreign('staff_role_id')->references('id')->on('staff_roles')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'staff_role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['staff_role_id']);
                $table->dropColumn('staff_role_id');
            });
        }
    }
};
