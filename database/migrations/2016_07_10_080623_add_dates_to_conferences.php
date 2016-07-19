<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDatesToConferences extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->date('start_date')->nullable()->default(null)->after('user_id');
            $table->date('end_date')->nullable()->default(null)->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
}
