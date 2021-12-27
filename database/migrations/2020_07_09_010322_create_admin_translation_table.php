<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_translation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('lang_code', 100)->nullable();
			$table->string('langkey', 200);
			$table->string('text', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admin_translation');
	}

}
