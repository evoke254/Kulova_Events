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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('phone_no')->nullable();
            $table->string('secondary_email')->nullable();
            $table->bigInteger('role_id')->default(4);
            $table->bigInteger('organization_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('phone_no');
            $table->dropColumn('secondary_email');
            $table->dropColumn('role_id');
            $table->dropColumn('company_id');
        });
    }
};
