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
        Schema::create('sales_tax_territories', function (Blueprint $table) {
            $table->id();
            $table->string('short_name')->unique();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('address', 2000)->nullable();
            $table->string('head')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_tax_territories');
    }
};