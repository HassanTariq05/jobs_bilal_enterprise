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
        Schema::create('job_performance_sheet_data', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_performance_id');

/*            
            $table->foreignId('job_invoice_detail_id')->nullable()->default(0);
            $table->foreignId('job_bill_detail_id')->nullable()->default(0);
            $table->foreignId('account_title_id')->nullable()->default(0);

            $table->string('rate')->nullable();
            $table->string('qty')->nullable();
            $table->string('tax')->nullable();            
            $table->string('inv_container_item_code')->nullable();            
            $table->string('inv_container_item_des')->nullable();            
            $table->string('bill_container_item_code')->nullable();     
            $table->string('bill_container_item_des')->nullable();          
*/
            $table->string('bl_no')->nullable();
            $table->string('container_no')->nullable();
            $table->string('size')->nullable();
            $table->string('status')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('trucking_mode')->nullable();
            $table->string('date')->nullable();
            $table->string('loading_port')->nullable();
            $table->string('off_loading_port')->nullable();
            $table->string('party')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_performance_sheet_data');
    }
};
