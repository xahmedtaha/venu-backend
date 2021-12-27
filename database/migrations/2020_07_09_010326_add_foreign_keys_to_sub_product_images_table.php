<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSubProductImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sub_product_images', function(Blueprint $table)
		{
			$table->foreign('sub_product_id')->references('id')->on('sizes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sub_product_images', function(Blueprint $table)
		{
			$table->dropForeign('sub_product_images_sub_product_id_foreign');
		});
	}

}
