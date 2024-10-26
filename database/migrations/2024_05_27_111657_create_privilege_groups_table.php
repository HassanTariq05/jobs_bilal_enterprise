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
        Schema::create('privilege_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privilege_category_id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->integer('order_by')->default(0);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privilege_groups');
    }
};
