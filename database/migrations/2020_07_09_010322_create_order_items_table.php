<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('order_id')->unsigned()->index('order_items_order_id_foreign');
			$table->bigInteger('item_id')->unsigned()->index('order_items_item_id_foreign');
			$table->bigInteger('size_id')->unsigned()->index('order_items_size_id_foreign');
			$table->integer('quantity');
			$table->float('unit_price');
			$table->float('total');
			$table->softDeletes();
			$table->timestamps();
			$table->text('comment', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_products');
	}

}
