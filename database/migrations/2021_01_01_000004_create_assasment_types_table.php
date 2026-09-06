<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssasmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assasment_types', function (Blueprint $table) {
            $table->id();
            $table->string('assasment_type'); // Test 1, Quiz, Mid Exam, Final, Assignment, Model...
            $table->double('max_mark')->default(100); // ከፍተኛው ውጤት
            $table->double('weight')->default(100); // መቶኛ ክብደት
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
        Schema::dropIfExists('assasment_types');
    }
}
