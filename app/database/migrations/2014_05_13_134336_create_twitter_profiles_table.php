<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTwitterProfilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('twitter_profiles', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('twitter_id');
			$table->string('name');
			$table->string('screen_name');
			$table->string('location');
			$table->string('description');
			$table->string('url');
			$table->string('profile_image_url');
			$table->string('profile_image_url_https');
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
		Schema::drop('twitter_profiles');
	}

}
