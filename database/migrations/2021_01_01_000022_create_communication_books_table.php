<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationBooksTable extends Migration
{
    public function up()
    {
        Schema::create('communication_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->string('date'); // በኢትዮጵያ ቀን አቆጣጠር (2016-01-20)
            $table->enum('type', ['homework', 'conduct', 'notice', 'appreciation'])->default('homework'); // የቤት ስራ፣ ስነ-ምግባር፣ ማስታወቂያ፣ ምስጋና
            $table->string('title'); // ርዕስ
            $table->text('message'); // የመምህሩ መልዕክት
            $table->text('parent_reply')->nullable(); // የወላጁ ምላሽ
            $table->boolean('is_acknowledged')->default(false); // ወላጁ ማየቱን ማረጋገጫ (Acknowledge)
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('communication_books');
    }
}
