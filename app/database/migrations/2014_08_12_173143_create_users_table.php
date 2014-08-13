<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('users', function($table)
	    {
	        $table->increments('id');
	        $table->string('name', 128)->nullable();
	        $table->string('email')->nullable();
	        $table->string('password', 60)->nullable();
	        $table->string('facebook_id', 200)->nullable();
	        $table->text('facebook_oauth')->nullable();
	        $table->text('twitter_oauth')->nullable();
	        $table->text('google_oauth')->nullable();
	        $table->text('flickr_oauth')->nullable();
	        $table->text('instagram_oauth')->nullable();
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
		Schema::drop('users');
	}

}
