<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('student_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->decimal('discount_percentage', 5, 2)->default(0.00); // ቅናሽ በመቶኛ (ለምሳሌ፡ 25%, 50%, 100% ነጻ)
            $table->string('reason')->nullable(); // የወንድማማች ቅናሽ፣ የነጻ ትምህርት እድል (Scholarship)...
            $table->string('academic_year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_discounts');
    }
}
