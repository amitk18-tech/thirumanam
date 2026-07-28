<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_careers', function (Blueprint $table) {
            $table->id();

            // Foreign key to profile
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            // Education & Career
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('income')->nullable();
            $table->string('work_location')->nullable();
            $table->string('study_details')->nullable();
            $table->string('career_profile')->nullable();

            // Earnings details
            $table->string('earnings')->nullable();
            $table->decimal('income_amount', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_careers');
    }
};