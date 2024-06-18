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
        Schema::create('user_chats_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('SenderID');
            $table->foreign('SenderID')->on('users')->references('id');
            $table->unsignedBigInteger('ReceiverID');
            $table->foreign('ReceiverID')->on('users')->references('id');
            $table->unsignedBigInteger('ChatID');
            $table->foreign('ChatID')->on('user_chats')->references('id');
            $table->enum('Type' , ['Text' , 'Image'])->default('Text');
            $table->text('Message');
            $table->text('Image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chats_messages');
    }
};
