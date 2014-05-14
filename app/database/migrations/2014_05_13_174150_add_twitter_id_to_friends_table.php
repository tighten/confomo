<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTwitterIdToFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('friends', function(Blueprint $table) {
			$table->integer('twitter_id')->unsigned();
			// $table->foreign('twitter_id')
				// ->references('id')
				// ->on('twitter_profiles');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('friends', function(Blueprint $table) {
			$table->dropColumn('twitter_id');
		});
	}

}
