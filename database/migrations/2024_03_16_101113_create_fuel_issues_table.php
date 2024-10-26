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
        Schema::create('fuel_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tank_id');
            $table->foreignId('fleet_id');
            $table->foreignId('operation_id');
            //$table->foreignId('driver_id');
            $table->date('fill_date');
            $table->integer('qty');
            $table->string('driver');
            $table->string('odometer_reading');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_issues');
    }
};
