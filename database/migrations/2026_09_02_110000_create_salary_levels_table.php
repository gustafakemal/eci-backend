<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryLevelsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_levels', function (Blueprint $table) {
            $table->id();
            $table->string('level')->unique();
            $table->decimal('gaji_min', 15, 2);
            $table->decimal('gaji_max', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_levels');
    }
}
