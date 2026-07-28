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
        Schema::create('astronomic_information', function (Blueprint $table) {
            $table->id();

            // Foreign key to profiles
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            // Astronomic Information
            $table->string('star')->nullable();
            $table->string('rasi')->nullable();
            $table->string('nakshatra')->nullable();
            $table->string('charan')->nullable();
            $table->string('padam')->nullable();              // e.g., PADAM3
            $table->string('ganam')->nullable();
            $table->string('nadi')->nullable();
            $table->string('dosham')->nullable();             // e.g., No
               $table->string('type_of_dosham')->nullable();   
            $table->string('paksha')->nullable();             // e.g., KRISHNA
            $table->string('tithi')->nullable();              // e.g., CHADURTHI
            $table->string('directional_balance')->nullable();// e.g., VENUS
            $table->date('date_of_birth')->nullable();
            $table->string('day_of_birth')->nullable();       // e.g., Monday
            $table->string('birth_time')->nullable();         // e.g., 3.30pm
            $table->string('birth_place')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('birth_state')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('lakknam')->nullable();            // e.g., ஜலகண்டாபுரம்
            $table->string('horoscope_matching')->nullable(); // e.g., EXACTLY
             $table->string('year')->nullable();     
            $table->string('month')->nullable();
            $table->string('day')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astronomic_information');
    }
};