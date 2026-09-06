<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semisters', function (Blueprint $table) {
            $table->id();
            $table->string('semister_name'); // Semester 1, Semester 2, Quarter 1, Quarter 2...
            $table->string('academic_year'); // 2016 E.C (2023/2024)
            $table->boolean('is_current')->default(false); // አሁን ያለንበት ሴሚስተር
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semisters');
    }
}
