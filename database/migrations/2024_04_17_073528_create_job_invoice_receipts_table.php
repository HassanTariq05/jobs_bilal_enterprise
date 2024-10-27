<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_invoice_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_tax_territory_id')->default(0)->nullable();
            $table->foreignId('bank_id')->default(0)->nullable();
            $table->foreignId('bank_account_id')->default(0)->nullable(); 
            $table->foreignId('payment_mode_id')->default(0);

            $table->string('receipt_no')->unique();
            $table->string('document_date')->date();
            $table->float('instrument_amount', 23, 2)->nullable();
            $table->string('instrument_number')->nullable();
            $table->date('instrument_date')->nullable();
            $table->string('received_from')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_invoice_receipts');
    }
};
