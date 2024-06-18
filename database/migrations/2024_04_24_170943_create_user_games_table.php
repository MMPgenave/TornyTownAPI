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
        Schema::create('user_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->on('users')->references('id');
            $table->string('Name');
            $table->integer('Level');
            $table->string('Rank');
            $table->float('XP')->default(0);
            $table->float('TotalXP')->default(0);
            $table->integer('total_game_played')->default(0);
            $table->integer('total_game_wins')->default(0);
            $table->integer('total_game_loses')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_games');
    }
};
