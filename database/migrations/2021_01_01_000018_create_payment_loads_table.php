<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentLoadsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_loads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // የክፍያው መጠን በብር
            $table->string('academic_year'); // 2016 E.C
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_loads');
    }
}
