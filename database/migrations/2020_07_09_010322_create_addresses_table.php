<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->unsigned()->index('addresses_user_id_foreign');
			$table->string('lat', 191);
			$table->string('long', 191);
			$table->string('address', 191);
			$table->string('flat', 191)->nullable();
			$table->string('floor', 191)->nullable();
			$table->string('building', 191)->nullable();
			$table->timestamps();
			$table->bigInteger('city_id')->unsigned();
			$table->bigInteger('place_id')->unsigned()->nullable();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('addresses');
	}

}
