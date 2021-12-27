<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('email', 191)->nullable()->unique('email');
			$table->string('password', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('facebook_token', 191)->nullable();
			$table->string('google_token', 191)->nullable();
            $table->string('firebase_token', 191)->nullable();
            $table->string('platform')->default('IOS');
			$table->string('name', 191)->nullable();
			$table->string('hash_code', 191)->nullable();
			$table->string('pin_code', 191)->nullable();
			$table->string('verified_at', 100)->nullable();
			$table->string('lang', 191)->default('ar');
			$table->softDeletes();
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
