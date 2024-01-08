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
        Schema::table('invites', function (Blueprint $table) {
            $table->boolean('registration_status')->nullable()->default(false);
            $table->string('attendance_mode')->nullable();
            $table->json('merchandise')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invites', function (Blueprint $table) {
            //
            $table->dropColumn('registration_status');
            $table->dropColumn('attendance_mode');
            $table->dropColumn('merchandise');
        });
    }
};
