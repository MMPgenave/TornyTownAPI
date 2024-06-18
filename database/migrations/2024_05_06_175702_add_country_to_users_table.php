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
            $table->string('Country')->after('Birthday')->nullable();
            $table->string('City')->after('Birthday')->nullable();
            $table->bigInteger('XP')->after('Gem')->default(0);
            $table->bigInteger('RankXP')->after('Gem')->default(0);
            $table->bigInteger('Level')->after('Gem')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
