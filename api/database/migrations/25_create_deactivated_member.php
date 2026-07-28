<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up()
    {
        Schema::create('deactivated_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
 
            // Foreign key constraint to members table
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('deactivated_members');
    }
};