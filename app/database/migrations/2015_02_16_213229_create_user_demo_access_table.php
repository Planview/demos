<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDemoAccessTable extends Migration {

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        // Creates the user_demo_access table
        Schema::create('user_demo_access', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('demo_id')->unsigned();
            $table->foreign('demo_id')->references('id')->on('demos');
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
        Schema::table('user_demo_access', function (Blueprint $table) {
            $table->dropForeign('user_demo_access_user_id_foreign');
            $table->dropForeign('user_demo_access_demo_id_foreign');
        });

        Schema::drop('user_demo_access');
    }

}
