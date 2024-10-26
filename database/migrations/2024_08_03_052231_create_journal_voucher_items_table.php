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
        Schema::create('journal_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_voucher_id');
            $table->foreignId('account_title_id');
            $table->foreignId('location_id'); // cost center
            $table->string('debit')->nullable();
            $table->string('credit')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_voucher_items');
    }
};
