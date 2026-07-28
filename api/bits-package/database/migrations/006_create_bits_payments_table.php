<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bits_payments', function (Blueprint $table) {
            $table->id();

            // Generic reference (order / booking / etc)
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            // Payment info
            $table->string('gateway')->default('razorpay');
            $table->string('payment_method')->nullable();

            // Razorpay data
            $table->string('transaction_id')->unique()->nullable();

            $table->decimal('amount', 10, 2);

            $table->enum('status', [
                'initiated',
                'confirmed',
                'failed',
                'refunded'
            ])->default('initiated');

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};