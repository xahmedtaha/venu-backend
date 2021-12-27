<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminLangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_lang', function(Blueprint $table)
		{
			$table->integer('id');
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
		Schema::drop('admin_lang');
	}

}
