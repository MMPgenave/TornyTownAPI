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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('TTID')->unique();
            $table->string('FirstName')->nullable();
            $table->string('LastName')->nullable();
            $table->string('UserName')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('Bio')->nullable();
            $table->bigInteger('total_game_played')->default(0);
            $table->bigInteger('total_game_wins')->default(0);
            $table->bigInteger('total_game_loses')->default(0);
            $table->enum('Type' , ['Bronze' , 'Silver' , 'Gold' , 'Diamond'])->default('Bronze');
            $table->float('Coin')->default(0);
            $table->float('Gem')->default(0);
            $table->enum('Gender' , ['Male' , 'Female' , 'Other'])->default('Male');
            $table->string('Avatar');
            $table->date('Birthday')->nullable();
            $table->string('Header')->nullable();
            $table->string('Frame')->nullable();
            $table->unsignedBigInteger('ReferralUser')->nullable();
            $table->foreign('ReferralUser')->on('users')->references('id');
            $table->enum('Profile' , ['Public' , 'Private' ])->default('Public');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
