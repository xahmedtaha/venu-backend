<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('table_id');
			$table->unsignedBigInteger('resturant_id');
			$table->unsignedBigInteger('branch_id');
			$table->float('sub_total');
			$table->float('tax')->default(0.00);
			$table->float('tax_value')->default(0.00);
			$table->float('service')->default(0.00);
			$table->float('service_value')->default(0.00);
			$table->float('total');
			$table->integer('status')->comment('0: active, 1: closed');
			$table->integer('order_number');
			$table->integer('number_of_products');
			$table->float('discount')->default(0.00);
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
		Schema::drop('orders');
	}

}
