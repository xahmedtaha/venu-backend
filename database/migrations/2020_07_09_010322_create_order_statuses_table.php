<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_statuses', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('order_id')->unsigned()->index('order_statuses_order_id_foreign');
			$table->bigInteger('emp_id')->unsigned()->default(0)->index('order_statuses_emp_id_foreign');
			$table->integer('status')->comment('0: pending, 1: preparing, 2: isDelivering, 3: isDelivered');
			$table->string('note', 191)->nullable();
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
		Schema::drop('order_statuses');
	}

}
