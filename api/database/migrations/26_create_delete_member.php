<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
       Schema::create('deleted_members', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('member_id');
    $table->unsignedBigInteger('deleted_by')->nullable(); // admin/user
    $table->timestamp('deleted_at');
});
    }

    public function down()
    {
        Schema::dropIfExists('deleted_members');
    }
};