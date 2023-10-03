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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('template_type');
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('is_active')->nullable();

            $table->string('logo')->nullable();
            $table->string('heading')->nullable();
            $table->text('paragraph')->nullable();
            $table->text('footer')->nullable();
            $table->string('button_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
