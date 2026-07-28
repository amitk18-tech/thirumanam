<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bits_invoices', function (Blueprint $table) {
            $table->id();

            // ------------------------
            // Identity
            // ------------------------
            $table->string('invoice_no')->unique();
            $table->string('reference_no')->nullable(); // PO / Booking ID / External ref

            // ------------------------
            // Relations
            // ------------------------
            // Using unsignedBigInteger instead of foreignId(...)->constrained() to avoid foreign key constraints failing 
            // if tables don't exist in the package's context or are in a different order.
            // Ideally, we'd use constrained columns if we are sure of the table existence.
            $table->unsignedBigInteger('project_finance_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('business_id')->nullable(); // Kept from original bits-package migration if needed for multitenancy

            // ------------------------
            // Company Snapshot
            // ------------------------
            $table->string('company_name_snapshot')->nullable();
            $table->text('company_address_snapshot')->nullable();
            $table->string('company_gstin')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_logo_path')->nullable();

            // Bank / Payment snapshot
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('payment_qr')->nullable();
            
            // Allow storing full objects as JSON if needed by other apps, 
            // but for bits-system compatibility we have flat fields above.
            $table->json('bill_from')->nullable(); 

            // ------------------------
            // Customer Snapshot
            // ------------------------
            $table->string('customer_name_snapshot')->nullable();
            $table->text('customer_address_snapshot')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_gstin')->nullable();
            
            $table->json('customer_details')->nullable();
            $table->json('bill_to')->nullable();

            // ------------------------
            // Invoice meta
            // ------------------------
            $table->string('invoice_title')->default('TAX INVOICE');
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->string('invoice_type')->default('invoice');
            $table->string('currency_code', 3)->default('USD');

            // ------------------------
            // Amounts
            // ------------------------
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0); // alias for discount
            $table->string('discount_type')->default('flat'); // In bits-system it's enum, string is safer here

            $table->decimal('taxable_amount', 15, 2)->default(0);

            $table->decimal('cgst', 15, 2)->default(0);
            $table->decimal('sgst', 15, 2)->default(0);
            $table->decimal('igst', 15, 2)->default(0);

            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);

            // ------------------------
            // Payment tracking
            // ------------------------
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('balance_amount', 15, 2)->default(0);
            $table->decimal('paid_percentage', 5, 2)->default(0);

            $table->string('status')->default('draft')->index();

            // ------------------------
            // PDF / Legal text snapshot
            // ------------------------
            $table->text('terms_and_conditions')->nullable();
            $table->text('footer_note')->nullable();
            $table->string('authorized_sign_name')->nullable();
            $table->string('authorized_sign_image')->nullable();
            
            $table->text('notes')->nullable();
            $table->text('terms')->nullable(); // alias for terms_and_conditions
            $table->text('footer_text')->nullable(); // alias for footer_note

            // ------------------------
            // System
            // ------------------------
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bits_invoices');
    }
};
