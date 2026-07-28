<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('token');
            $table->string('type'); // e.g., otp, setup, password_reset
            $table->string('purpose')->nullable(); // more specific purpose
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_used')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
};
