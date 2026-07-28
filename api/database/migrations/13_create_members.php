<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade'); // Which profile is now a member
            $table->foreignId('membership_id')->constrained()->onDelete('cascade'); // Plan they are subscribed to


            $table->date('start_date'); // Actual start date
            $table->date('end_date');   // Expiry date

            $table->integer('sent_interest_allowed')->nullable()->default(0);
            $table->integer('profiles_view_allowed')->nullable()->default(0);
            $table->integer('messages_sent_allowed')->nullable()->default(0);
            $table->integer('sent_interest_remaining')->nullable()->default(0);
            $table->integer('profiles_view_remaining')->nullable()->default(0);
            $table->integer('messages_sent_remaining')->nullable()->default(0);


            // mmembership renewal & reminders

            $table->boolean('membership_expired')->default(false);

            $table->boolean('send_reminder')->default(false);
            $table->boolean('auto_renewal')->default(false);

            $table->enum('status', ['inactive', 'active', 'expired', 'cancelled', 'pending'])->default('active');
            $table->boolean('is_verified')->default(false); // user verified via email/phone
            $table->boolean('verified_by_admin')->default(false);
            $table->boolean('blocked_by_admin')->default(false);
            $table->boolean('rejected_by_admin')->default(false);

            $table->boolean('is_reported')->default(false);
            $table->integer('report_profile')->nullable()->default(0);
            $table->boolean('is_matched')->default(false);

            $table->softDeletes();

            $table->boolean('is_deleted')->default(false);
            $table->string('is_closed')->nullable();
            $table->integer('isRenewed')->nullable()->default(0);
            $table->boolean('is_deactivated')->default(false);

            $table->string('member_no')->nullable();
            $table->string('prefix_id')->nullable();

            $table->unsignedBigInteger('legacy_member_id')->nullable()->index();

            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};