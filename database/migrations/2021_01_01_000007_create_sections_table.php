<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name'); // A, B, C, D...
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('stream_id')->nullable()->constrained('streams')->onDelete('set null');
            $table->string('room_number')->nullable(); // የመማሪያ ክፍል ቁጥር
            $table->integer('capacity')->default(40); // በክፍሉ የሚገቡ ተማሪዎች ብዛት
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
        Schema::dropIfExists('sections');
    }
}
