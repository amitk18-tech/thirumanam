<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('family_details', function (Blueprint $table) {
            $table->id(); // Unique ID

            // Foreign key to profiles
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');

            // Parents
            $table->string('surname')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('father_vangusam')->nullable();
            $table->string('mother_vangusam')->nullable();

            // Soveran Details
            $table->string('property_description_other')->nullable();
            $table->unsignedInteger('soveran_details')->nullable();

            // Siblings
            $table->unsignedInteger('brothers_count')->default(0);
            $table->unsignedInteger('brothers_married')->default(0);
            $table->unsignedInteger('sisters_count')->default(0);
            $table->unsignedInteger('sisters_married')->default(0);

            // Family background
            $table->string('family_status')->nullable();
            $table->string('family_type')->nullable();
            $table->string('family_values')->nullable();

            // Additional info
            $table->text('about_family')->nullable();

            // properties
            $table->text('property_description')->nullable();


            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_details');
    }
};