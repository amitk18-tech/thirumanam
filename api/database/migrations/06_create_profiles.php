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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); // Unique profile ID
 
            $table->string('introduction')->nullable();
 
            // Foreign key to users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->unsignedInteger('age')->nullable(); // auto-calculated (optional, can be filled by backend job)
            $table->string('marital_status')->nullable();
            $table->unsignedInteger('number_of_children')->nullable();
            $table->string('children_living_place')->nullable();
 
            // registered details / offline or online or
            $table->string('registration_mode')->default('online')->nullable();
 
            // membership details
            $table->string('membership_type')->default('default');
 
            // Astronomic Information
            $table->date('date_of_birth')->nullable();
            $table->string('day_of_birth')->nullable();
            $table->string('birth_time')->nullable();
            $table->string('birth_city')->nullable();     // e.g., 3.30pm// e.g., Monday
            $table->string('paksha')->nullable();             // e.g., KRISHNA
            $table->string('star')->nullable(); // myself, daughter, son, relative, etc.
            $table->string('rasi')->nullable(); // myself, daughter, son, relative, etc.
            $table->string('padam')->nullable();              // e.g., PADAM3
            $table->string('nakshatra')->nullable();
            $table->string('charan')->nullable();
            $table->string('lakknam')->nullable();            // e.g., ஜலகண்டாபுரம்
            $table->string('horoscope_matching')->nullable(); // e.g., EXACTLY
            $table->string('dosham')->nullable();             // e.g., No
            $table->string('tithi')->nullable();
            $table->string('ganam')->nullable();
            $table->string('nadi')->nullable();
            $table->string('type_of_dosham')->nullable();
            $table->string('other_dosham')->nullable();
 
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            // e.g., CHADURTHI
            $table->string('directional_balance')->nullable(); // e.g., VENUS
            $table->string('birth_place')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('birth_state')->nullable();
 
 
            // address details
            $table->string('native_place')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('landline')->nullable();
            $table->string('current_city')->nullable();
 
            // Physical Attributes
            $table->unsignedInteger('height')->nullable();        // in cm
            $table->unsignedInteger('weight')->nullable();        // in kg
            $table->string('complexion')->nullable();
            $table->string('body_type')->nullable();
            $table->string('body_art')->nullable();              // tattoos, piercings etc.
            $table->string('blood_group')->nullable();
            $table->string('physical_status')->nullable();       // normal, disabled etc.
            $table->string('eye_color')->nullable();
            $table->string('hair_color')->nullable();
 
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
 
            // Profile details
            $table->string('profile_photo')->nullable();
            $table->string('horoscope_file')->nullable(); // can be image/pdf
 
 
 
 
            $table->timestamps(); // created_at & updated_at
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
 