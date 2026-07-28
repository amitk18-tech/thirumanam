<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('member_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('activity_type'); // Member Activity
            $table->string('location')->nullable();
            $table->timestamps(); // includes created_at (Date)
            $table->string('status')->nullable();
            
            // Foreign key constraint to members table
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_activities');
    }
};