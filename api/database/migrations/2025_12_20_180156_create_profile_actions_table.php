<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_actions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_profile_id');
            $table->unsignedBigInteger('to_profile_id');

            $table->enum('action_type', ['shortlist', 'follow', 'block']);

            $table->timestamps();

            $table->unique(['from_profile_id', 'to_profile_id', 'action_type']);

            $table->foreign('from_profile_id')
                  ->references('id')->on('profiles')
                  ->onDelete('cascade');

            $table->foreign('to_profile_id')
                  ->references('id')->on('profiles')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_actions');
    }
};
