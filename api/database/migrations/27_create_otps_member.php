<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
Schema::create('otps', function (Blueprint $table) {
    $table->id();
    $table->string('mobile', 15);
    $table->string('otp_hash');
    $table->string('type'); // otp, first_time_login
    $table->timestamp('expires_at');
    $table->boolean('is_used')->default(false);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
};