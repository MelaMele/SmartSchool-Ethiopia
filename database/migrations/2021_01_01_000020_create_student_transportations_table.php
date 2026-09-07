<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTransportationsTable extends Migration
{
    public function up()
    {
        Schema::create('student_transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('route_name'); // የመስመሩ ስም (ለምሳሌ፡ ገርጂ - ቦሌ መስመር)
            $table->string('pickup_location')->nullable(); // መነሻ ቦታ
            $table->string('dropoff_location')->nullable(); // መድረሻ ቦታ
            $table->decimal('monthly_fee', 10, 2); // የወር ክፍያ
            $table->string('bus_number')->nullable(); // የታርጋ ቁጥር
            $table->string('academic_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_transportations');
    }
}
