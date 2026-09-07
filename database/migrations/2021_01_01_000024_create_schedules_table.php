<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']); // ሰኞ - ዓርብ
            $table->integer('period_number'); // ከ 1ኛ እስከ 7ኛ ክፍለ-ጊዜ
            $table->string('academic_year'); // 2016 ዓ.ም
            $table->timestamps();

            // አንድ መምህር በአንድ ሰዓት በሁለት ክፍል እንዳይመደብ መከላከያ
            $table->unique(['teacher_id', 'day_of_week', 'period_number', 'academic_year'], 'unique_teacher_schedule');
            // በአንድ ክፍል አንድ ሰዓት ላይ ሁለት ትምህርት እንዳይመደብ መከላከያ
            $table->unique(['class_id', 'section_id', 'day_of_week', 'period_number', 'academic_year'], 'unique_class_schedule');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
