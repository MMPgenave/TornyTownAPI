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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('PaymentID');
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')->on('users')->references('id');
            $table->enum('Type' , ['Buy' , 'Sell' , 'Convert' ]);
            $table->unsignedBigInteger('ItemID');
            $table->foreign('ItemID')->on('items')->references('id');
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
        Schema::dropIfExists('payments');
    }
};
