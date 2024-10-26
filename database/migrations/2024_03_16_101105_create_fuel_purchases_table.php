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
        Schema::create('fuel_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id');
            $table->foreignId('fuel_type_id');
            $table->foreignId('tank_id');
            $table->bigInteger('qty');
            $table->float('rate', 10, 2);
            $table->float('amount', 10, 2);
            $table->date('delivery_date');
            $table->float('freight_charges', 10, 2);
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
        Schema::dropIfExists('fuel_purchases');
    }
};
