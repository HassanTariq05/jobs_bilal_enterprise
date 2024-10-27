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
        Schema::create('job_performances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id');
            $table->foreignId('user_id');

            $table->string('file_original_name')->nullable();
            $table->string('file_original_ext')->nullable();
            $table->string('file_temp_name')->nullable();
            $table->string('stored_file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_performances');
    }
};
