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
        Schema::create('elective_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->integer('votes')->default(1);
            $table->unsignedBigInteger('election_id');
            $table->foreign('election_id')->references('id')->on('elections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elective_positions');
    }
};
