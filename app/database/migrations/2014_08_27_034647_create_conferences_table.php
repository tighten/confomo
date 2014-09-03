<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Confomo\Entities\User;
use Confomo\Entities\Conference;

class CreateConferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conferences', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 50);
			$table->boolean('list_is_public');
			$table->integer('user_id');
			$table->timestamps();
		});

		Schema::table('friends', function(Blueprint $table) {
			$table->integer('conference_id');
		});

		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn('public_list');
		});

		// Create a default conference for all users
		$users = User::all();
		$conferences = [];
		$i = 1;

		foreach ($users as $user)
		{
			$conferences[] = [
				'id' => $i,
				'name' => 'Default Conference',
				'list_is_public' => 0,
				'user_id' => $user->id
			];

			// Would have to queue these up if we had foreign key restrictions
			DB::statement(
				'UPDATE `friends` SET conference_id=:conference_id WHERE user_id=:user_id',
				[
					'conference_id' => $i,
					'user_id' => $user->id
				]
			);

			$i++;
		}

		Conference::insert($conferences);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conferences');

		Schema::table('friends', function(Blueprint $table) {
			$table->dropColumn('conference_id');
		});

		Schema::table('users', function(Blueprint $table) {
			$table->boolean('public_list')->default(false);
		});
	}

}
