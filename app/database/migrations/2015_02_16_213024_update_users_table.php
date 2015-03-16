<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        // Updates the users table
        Schema::table('users', function($table)
        {
            $table->string('company')->nullable();
            $table->date('expires')->nullable();
            $table->integer('isr_contact_id')->unsigned()->nullable();
            $table->foreign('isr_contact_id')
                  ->references('user_id')->on('isrs');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_isr_contact_id_foreign');
        });

        Schema::table('users', function($table)
        {
            $table->dropColumn(array('company', 'expires', 'isr_contact_id'));
        });
    }

}
