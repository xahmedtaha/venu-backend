<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSizesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sizes', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name_ar', 191);
			$table->string('name_en', 191);
			$table->float('price_before');
			$table->float('price_after');
			$table->bigInteger('item_id')->unsigned()->index('sizes_item_id_foreign');
			$table->bigInteger('resturant_id')->unsigned()->index('sizes_resturant_id_foreign');
			$table->softDeletes();
			$table->timestamps();
			$table->string('description_ar', 191)->nullable();
			$table->string('description_en', 191)->nullable();
			$table->float('discount')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sub_products');
	}

}
