<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('subcity')->nullable(); // ክፍለ ከተማ / ዞን
            $table->string('woreda')->nullable();  // ወረዳ
            $table->string('kebele')->nullable();  // ቀበሌ
            $table->string('house_number')->nullable(); // የቤት ቁጥር
            $table->string('phone_number')->nullable(); // ስልክ ቁጥር
            $table->string('secondary_phone')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
