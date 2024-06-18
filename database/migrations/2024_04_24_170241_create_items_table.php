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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->text('Description');
            $table->enum('Type' , ['Item' , 'NFT'])->default('Item');
            $table->unsignedBigInteger('Category');
            $table->foreign('Category')->on('items_categories')->references('id')->cascadeOnDelete();
            $table->float('Price');
            $table->integer('Count');
            $table->string('Image');
            $table->enum('Status' , ['ComingSoon' , 'Selling' , 'Finished'])->default('Selling');
            $table->enum('SpecialOffer' , ['No' , 'Yes' ])->default('No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
