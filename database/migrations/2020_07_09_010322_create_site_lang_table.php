<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSiteLangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_lang', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 155);
			$table->string('name', 200);
			$table->string('dir', 100)->nullable();
			$table->integer('stuts')->nullable();
			$table->string('photo', 300)->nullable();
			$table->string('is_main', 155)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_lang');
	}

}
