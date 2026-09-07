<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeJobPositionsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_job_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_title'); // ርዕሰ መምህር፣ መምህር፣ ሬጅስትራር፣ ሒሳብ ሹም፣ ጥበቃ...
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_job_positions');
    }
}
