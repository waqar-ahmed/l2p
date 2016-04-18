<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefreshTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refreshtokens', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('user_id');
            $table->string('refresh_token');
            $table->integer('expires_in');
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
        Schema::table('refreshtokens', function (Blueprint $table) {
            //
             Schema::drop('refreshtokens');
        });
    }
}
