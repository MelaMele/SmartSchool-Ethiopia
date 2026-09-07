<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogsTable extends Migration
{
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number'); // የተቀባዩ ስልክ (09...)
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->text('message'); // የተላከው መልዕክት
            $table->enum('type', ['attendance', 'fee_reminder', 'mark_alert', 'general_notice'])->default('general_notice');
            $table->enum('status', ['sent', 'failed', 'pending'])->default('sent');
            $table->string('response_id')->nullable(); // ከጌትዌዩ የሚመጣ የትዕዛዝ ቁጥር
            $table->foreignId('sent_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
