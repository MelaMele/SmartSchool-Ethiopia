<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique(); // EMP/2016/001
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_date')->nullable();
            $table->string('hired_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('education_status')->nullable(); // Diploma, Degree, Masters, PhD
            $table->string('marriage_status')->nullable(); // Single, Married, Divorced
            $table->decimal('net_salary', 10, 2)->default(0.00);
            $table->enum('hire_type', ['permanent', 'contract'])->default('permanent');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->foreignId('employee_job_position_id')->nullable()->constrained('employee_job_positions')->onDelete('set null');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
