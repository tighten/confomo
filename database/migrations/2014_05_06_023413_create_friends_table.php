<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFriendsTable extends Migration
{
    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('twitter');
            $table->string('type');
            $table->integer('user_id');
            $table->boolean('met');
            $table->integer('twitter_id')->unsigned();
            $table->text('notes');
            $table->integer('conference_id');
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
        Schema::drop('friends');
    }

}
