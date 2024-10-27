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
        Schema::create('booking_containers', function (Blueprint $table) {
            $table->id();

 //           $table->foreignId('job_performance_id');
            $table->string('booking')->nullable();
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
        Schema::dropIfExists('booking_containers');
    }
};
