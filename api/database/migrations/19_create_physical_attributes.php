<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physical_attributes', function (Blueprint $table) {
            $table->id();

            // Foreign key
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            // Physical Attributes
            $table->unsignedInteger('height')->nullable();        // in cm
            $table->unsignedInteger('weight')->nullable();        // in kg
            $table->string('complexion')->nullable();
            $table->string('body_type')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('physical_status')->nullable();       // normal, disabled etc.
            $table->string('eye_color')->nullable();
            $table->string('hair_color')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physical_attributes');
    }
};