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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manufacturer_id');
            $table->foreignId('fleet_type_id');
            $table->string('registration_number');
            $table->string('chassis_number');
            $table->string('engine_number');
            $table->string('model');
            $table->string('horsepower');
            $table->string('loading_capacity');
            $table->string('registration_city');
            $table->string('ownership');
            $table->string('lifting_capacity');
            $table->string('diesel_opening_inventory');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
