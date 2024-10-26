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
        Schema::create('job_bill_container_breakup_items', function (Blueprint $table) {
            $table->id();
            $table->integer('job_bill_container_breakup_id');

            $table->string('bl_no');
            $table->string('container_no');
            $table->string('size');
            $table->string('status');
            $table->string('vehicle_no');
            $table->string('trucking_mode');
            $table->string('date');
            $table->string('loading_port');
            $table->string('off_loading_port');
            $table->string('party');
            $table->string('remarks')->nullable();

            $table->float('rate', 23, 2);
            $table->integer('qty');            
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bill_container_breakup_items');
    }
};
