<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemosTable extends Migration {

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        // Creates the demos table
        Schema::create('demos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title',256);
            $table->text('description');
            $table->string('enterprise_version',64);
            $table->string('language',32);
            $table->text('demo_code');
            $table->text('related_content_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('demos');
    }

}
