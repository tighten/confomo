<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddApprovedToFriends extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->boolean('approved')->default(true)->after('met');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
