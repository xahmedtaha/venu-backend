<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToResturantImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('resturant_images', function(Blueprint $table)
		{
			$table->foreign('resturant_id')->references('id')->on('resturants')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('resturant_images', function(Blueprint $table)
		{
			$table->dropForeign('resturant_images_resturant_id_foreign');
		});
	}

}
