<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsrsTable extends Migration {

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        // Creates the isr table
        Schema::create('isrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users');
            $table->string('isr_first_name');
            $table->string('isr_last_name');
            $table->string('isr_phone');
            $table->string('isr_mobile_phone')->nullable();
            $table->string('isr_location');
            $table->softDeletes();
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
        Schema::table('isrs', function (Blueprint $table) {
            $table->dropForeign('isrs_user_id_foreign');
        });

        Schema::drop('isrs');
    }

}
