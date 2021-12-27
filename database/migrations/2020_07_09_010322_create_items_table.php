<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name_ar', 191);
			$table->string('name_en', 191)->nullable();
			$table->float('price_before')->nullable();
			$table->float('price_after');
			$table->float('discount')->nullable();
			$table->bigInteger('resturant_id')->unsigned()->index('items_resturant_id_foreign');
			$table->float('offer')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('description_ar', 191);
            $table->string('description_en', 191);
            $table->integer('side_slots')->default(0);
			$table->bigInteger('category_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
