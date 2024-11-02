<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyCountsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_counts', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->tinyInteger('month');
            $table->tinyInteger('count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_counts');
    }
}
