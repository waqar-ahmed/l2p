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
        Schema::create('access_tokens', function (Blueprint $table) {
            //
            $table->increments('id');      
            $table->string('access_token');
            $table->string('token_type');
            $table->integer('expires_in');
            $table->string('refresh_token');
            $table->string('remember_token')->nullable();;
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
        Schema::table('access_tokens', function (Blueprint $table) {
            //
            Schema::drop('access_tokens');
        });
    }
}
