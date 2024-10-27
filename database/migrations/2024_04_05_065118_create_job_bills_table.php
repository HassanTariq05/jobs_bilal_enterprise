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
        Schema::create('job_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('party_id');
            $table->date('bill_date');
            $table->string('bill_no');
            $table->string('due_date');
            $table->string('vendor_ref');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bills');
    }
};
