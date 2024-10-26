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
        Schema::create('job_containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('loading_point_id');
            $table->foreignId('destination_point_id');
            $table->string('container_no');
            $table->string('size');
            $table->string('goods_description');
            $table->string('gross_weight');
            $table->string('measurement');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_containers');
    }
};
