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
        Schema::create('partner_preferences', function (Blueprint $table) {
            $table->id(); // Unique ID
 
            // Foreign key to profiles
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');
 
            // Basic filters
            $table->unsignedInteger('preferred_age_min')->nullable();
            $table->unsignedInteger('preferred_age_max')->nullable();
            $table->unsignedInteger('preferred_height_min')->nullable(); // in cm
            $table->unsignedInteger('preferred_height_max')->nullable(); // in cm
 
            $table->unsignedInteger('age')->nullable();
            $table->unsignedInteger('height')->nullable();
 
            $table->string('marital_status')->nullable();
            $table->string('children_acceptables')->nullable();
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->string('location')->nullable();
            $table->string('profession')->nullable();
            $table->string('body_type')->nullable(); // slim / average / athletic / heavy
            $table->string('physical_status')->nullable(); // normal / disabled / others
 
            // Horoscope & traditions
            $table->boolean('horoscope_required')->default(false);
            $table->string('family_type')->nullable(); // joint / nuclear (if needed)
 
            $table->string('horoscope_natchathiram')->nullable(); // store list
            $table->string('horoscope_rasi')->nullable();
            $table->string('dosham')->nullable();
            $table->string('type_of_dosham')->nullable();
            $table->string('other_dosham')->nullable();
            $table->text('expectations')->nullable();
            $table->unsignedInteger('weight')->nullable(); // in kg
 
            // Lifestyle
            $table->string('drinking')->nullable(); // yes / no / occasionally
            $table->string('smoking')->nullable(); // yes / no / occasionally
            $table->string('eating_habits')->nullable(); // veg / non-veg / eggetarian / vegan
 
            // Additional info
            $table->text('about_partner')->nullable();
 
            $table->timestamps(); // created_at & updated_at
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_preferences');
    }
};
 