<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesstokens', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('user_id');
            $table->string('access_token');
            $table->string('token_type');
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
        Schema::table('accesstokens', function (Blueprint $table) {
            //
            Schema::drop('accesstokens');
        });
    }
}
