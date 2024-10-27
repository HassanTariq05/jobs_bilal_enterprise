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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('party_id');
            $table->foreignId('company_id');
            $table->foreignId('location_id');
            $table->foreignId('job_type_id');
            $table->foreignId('job_status_id')->default(1);
            $table->foreignId('approved')->default(0);

            $table->string('job_no')->unique();
            $table->date('document_date');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
