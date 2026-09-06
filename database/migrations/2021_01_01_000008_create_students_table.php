<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // ልዩ የተማሪ መታወቂያ ቁጥር (STD/2016/001)
            $table->string('first_name'); // የተማሪው ስም
            $table->string('middle_name'); // የአባት ስም
            $table->string('last_name'); // የአያት ስም
            $table->enum('gender', ['male', 'female']); // ጾታ
            $table->string('birth_date')->nullable(); // የልደት ቀን (በኢትዮጵያ ዘመን አቆጣጠር)
            $table->string('photo')->nullable(); // የተማሪው ፎቶ
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('stream_id')->nullable()->constrained('streams')->onDelete('set null');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['active', 'transferred', 'graduated', 'suspended'])->default('active');
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
        Schema::dropIfExists('students');
    }
}
