<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('field_of_study')->nullable(); // Mathematics, Physics, English...
            $table->string('place_of_study')->nullable(); // AAU, BDU, ASTU...
            $table->string('teacher_training_institute')->nullable(); // Kotebe, TTI...
            $table->string('debut_as_a_teacher')->nullable(); // ማስተማር የጀመረበት ዓመት
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
