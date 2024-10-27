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
        Schema::create('job_invoice_container_breakups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_invoice_id');
            $table->foreignId('job_invoice_detail_id')->nullable();
            $table->foreignId('sales_tax_territory_id');
            $table->foreignId('account_title_id');
            $table->integer('container_item_code');
            $table->float('rate', 23, 2);
            $table->integer('qty');
            $table->float('amount', 23, 2);
            $table->float('tax_percentage', 3, 2);
            $table->float('tax', 23, 2);
            $table->float('net', 23, 2);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_invoice_container_breakups');
    }
};
