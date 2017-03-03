<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_nickname')->nullable()->after('twitter_id');
            $table->boolean('userIsSearchable')->nullable()->before('remember_token');
            $table->boolean('conferenceListIsPublic')->nullable()->before('remember_token');
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
            $table->dropColumn(['twitter_nickname', 'userIsSearchable', 'conferenceListIsPublic']);
        });
    }
}
