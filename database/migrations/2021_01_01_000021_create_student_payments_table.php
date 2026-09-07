<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2); // የተከፈለው መጠን
            $table->string('fs_number')->unique(); // የኢትዮጵያ የሽያጭ ደረሰኝ ቁጥር (FS Number)
            $table->string('ethiopian_month'); // መስከረም፣ ጥቅምት፣ ኅዳር፣ ታኅሣሥ፣ ጥር፣ የካቲት፣ መጋቢት፣ ሚያዝያ፣ ግንቦት፣ ሰኔ
            $table->string('payment_date'); // የተከፈለበት ቀን በኢትዮጵያ ዘመን አቆጣጠር
            $table->enum('payment_method', ['cash', 'cbe_birr', 'telebirr', 'bank_transfer'])->default('cash');
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null'); // ገንዘብ ያዥ
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_payments');
    }
}
