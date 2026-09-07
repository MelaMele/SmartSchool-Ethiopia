<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('home_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('academic_year'); // 2016 E.C
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_rooms');
    }
}
