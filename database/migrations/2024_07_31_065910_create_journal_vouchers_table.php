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
        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('voucher_type_id');
            $table->foreignId('company_id');
            $table->foreignId('account_title_id');
            $table->foreignId('location_id'); // cost center
            $table->foreignId('payment_mode_id');

            $table->string('voucher_no');
            $table->date('date');
            $table->string('cheque_no');
            $table->date('cheque_date');
            $table->string('pay_to');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_vouchers');
    }
};
