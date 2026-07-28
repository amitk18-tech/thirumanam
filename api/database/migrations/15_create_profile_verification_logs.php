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
        Schema::create('profile_verification_logs', function (Blueprint $table) {
            $table->id(); // Unique log ID

            // Relations
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // admin user

            // Action details
            $table->enum('action', ['verify', 'block', 'delete', 'mark_fake']);
            $table->text('reason')->nullable();

            $table->timestamps(); // created_at = logged time, updated_at (if edited)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_verification_logs');
    }
};