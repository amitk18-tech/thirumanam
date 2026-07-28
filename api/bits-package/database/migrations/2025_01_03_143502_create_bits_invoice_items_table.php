<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bits_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id'); // Relation to bits_invoices

            $table->string('item_name');
            $table->text('description')->nullable();
            
            $table->decimal('qty', 15, 2)->default(0);
            $table->decimal('rate', 15, 2)->default(0); // unit_price
            
            $table->decimal('line_subtotal', 15, 2)->default(0);
            
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            
            $table->decimal('total_amount', 15, 2)->default(0);

            // Aliases for compatibility
            $table->decimal('quantity', 15, 2)->default(0); // alias for qty
            $table->decimal('unit_price', 15, 2)->default(0); // alias for rate
            $table->decimal('tax_percent', 5, 2)->default(0); // alias for tax_percentage
            $table->decimal('total', 15, 2)->default(0); // alias for total_amount

            // No timestamps in bits-system invoice_items
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bits_invoice_items');
    }
};
