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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elective_position_id');
            $table->foreign('elective_position_id')->references('id')->on('elective_positions');


            $table->unsignedBigInteger('candidate_elective_position_id');
            $table->foreign('candidate_elective_position_id')->references('id')->on('candidate_elective_positions');

            $table->unsignedBigInteger('invite_id');
            $table->foreign('invite_id')->references('id')->on('invites');


            $table->integer('vote')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
