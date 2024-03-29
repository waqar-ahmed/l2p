<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('access_token_id')->nullable();
            $table->string('device_code');
            $table->string('user_code');
            $table->string('verification_url');
            $table->integer('expires_in');
            $table->integer('interval');
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
        Schema::table('device_tokens', function (Blueprint $table) {
            //
            Schema::drop('device_tokens');
        });
    }
}
