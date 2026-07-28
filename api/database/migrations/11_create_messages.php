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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Unique ID

            // Relations
            $table->unsignedBigInteger('match_id')->nullable();
            $table->foreignId('sender_profile_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('receiver_profile_id')->constrained('profiles')->onDelete('cascade');

            // Message content
            $table->text('message_text');
            $table->string('message_type')->default('text');

            // Status
            $table->boolean('is_read')->default(false);

            $table->timestamps(); // created_at & updated_at (sent time)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};