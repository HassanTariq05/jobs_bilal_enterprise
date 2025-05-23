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
        Schema::create('job_invoice_receipt_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_invoice_receipt_id');
            $table->foreignId('job_invoice_id');
            $table->foreignId('account_title_id')->default(0)->nullable();

            $table->float('sales_tax_with_held', 23, 3)->nullable();
            $table->float('income_tax_with_held', 23, 2)->nullable();
            $table->float('adjustment_amount', 23, 2)->nullable();
            $table->float('received_amount', 23, 2);
            $table->float('total', 23, 2);

            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_invoice_receipt_details');
    }
};
