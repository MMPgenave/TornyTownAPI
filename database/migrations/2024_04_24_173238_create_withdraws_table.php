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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('WithdrawID');
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->on('users')->references('id');
            $table->enum('Type' , ['Crypto' , 'Paypal' , 'CreditCard' , 'PerfectMoney']);
            $table->string('Gateway');
            $table->string('Blockchain');
            $table->string('Currency')->nullable();
            $table->string('CurrencyAmount')->nullable();
            $table->string('CurrencyFinalAmount')->nullable();
            $table->float('Amount');
            $table->float('FinalAmount');
            $table->string('WalletAddress')->nullable();
            $table->text('Hash')->nullable();
            $table->enum('Status' , ['Pending' , 'Paid' , 'Canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
