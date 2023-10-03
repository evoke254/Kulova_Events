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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->bigInteger('landing_page_id')->nullable();
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('organization_department_id')->nullable();
            $table->unsignedBigInteger('email_template_id');
            $table->unsignedBigInteger('mail_list_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('landing_page_id');
            $table->dropColumn('user_id');
            $table->dropColumn('organization_department_id');
            $table->dropColumn('email_template_id');
            $table->dropColumn('mail_list_id');
        });
    }
};
