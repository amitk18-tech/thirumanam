<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horoscope_boxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');   // member id
            $table->integer('box_number');           // 1 to 12
            $table->integer('item_number')->nullable();  // box item number ( 1 to 6)
            $table->string('type')->nullable();          // type of zodiac or feature
            $table->string('value')->nullable();        // value or content of the horoscope element
            $table->timestamps();

            // If you have users table
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horoscope_boxes');
    } 
};