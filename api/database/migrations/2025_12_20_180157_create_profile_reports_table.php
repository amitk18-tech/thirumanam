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
        Schema::create('profile_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('reported_by_profile_id');
            $table->unsignedBigInteger('reported_profile_id');

            $table->string('reason');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->unique(['reported_by_profile_id', 'reported_profile_id'], 'profile_reports_unique');

            $table->foreign('reported_by_profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('reported_profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_reports');
    }
};
