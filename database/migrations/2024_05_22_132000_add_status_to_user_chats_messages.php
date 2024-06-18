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
        Schema::table('user_chats_messages', function (Blueprint $table) {
            $table->enum('Status' , ['New' , 'Read'])->default('New')->after('Image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_chats_messages', function (Blueprint $table) {
            //
        });
    }
};
