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
        Schema::create('game_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('RoomID');
            $table->foreign('RoomID')->on('game_rooms')->references('id');
            $table->json('Players');
            $table->string('GameName');
            $table->integer('Bet');
            $table->unsignedBigInteger('Winner');
            $table->foreign('Winner')->on('users')->references('id');
            $table->unsignedBigInteger('Loser');
            $table->foreign('Loser')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_histories');
    }
};
