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
        Schema::create('job_bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_bill_id');
            $table->foreignId('account_title_id');
            $table->foreignId('sales_tax_territory_id');

            $table->string('container_item_code')->nullable();

            $table->integer('qty');
            $table->float('rate', 23, 2);
            $table->float('amount', 23, 2);
            $table->float('tax_percentage', 3,2)->nullable();
            $table->float('tax', 23, 2)->nullable();
            $table->float('net', 23, 2);
            $table->string('description')->nullable();
            $table->integer('is_manual')->default(1);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bill_details');
    }
};
