<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTweetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweeters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('url')->nullable();
            $table->string('url_display')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('friends', function (Blueprint $table) {
            $table->dropColumn(['name', 'location', 'url', 'url_display', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tweeters');

        Schema::table('friends', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('url')->nullable();
            $table->string('url_display')->nullable();
            $table->string('description')->nullable();
        });
    }
}
