<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMarkListsTable extends Migration
{
    public function up()
    {
        Schema::create('student_mark_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('semister_id')->constrained('semisters')->onDelete('cascade');
            $table->foreignId('assasment_type_id')->constrained('assasment_types')->onDelete('cascade');
            $table->double('mark'); // የተማሪው ውጤት
            $table->double('load')->default(100); // የመቶኛ ክብደት
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_mark_lists');
    }
}
