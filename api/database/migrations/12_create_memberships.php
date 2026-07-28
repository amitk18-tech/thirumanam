<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('duration_days');
            $table->integer('sent_interest_allowed')->default(0);
            $table->integer('profiles_view_allowed')->default(0);
            $table->integer('messages_sent_allowed')->default(0);
            $table->string('membership_mode')->default('online');

            // ✅ FIXED
            $table->unsignedInteger('savaran_plan')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
