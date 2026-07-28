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
        Schema::create('interests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_profile_id');
            $table->unsignedBigInteger('receiver_profile_id');

            $table->enum('status', ['pending', 'accepted', 'rejected'])
                ->default('pending');

            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->unique(['sender_profile_id', 'receiver_profile_id', 'status']);

            $table->foreign('sender_profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('receiver_profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interests');
    }
};
