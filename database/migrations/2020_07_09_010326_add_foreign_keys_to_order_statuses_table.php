<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrderStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_statuses', function(Blueprint $table)
		{
			$table->foreign('emp_id')->references('id')->on('employees')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('order_id')->references('id')->on('orders')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('order_statuses', function(Blueprint $table)
		{
			$table->dropForeign('order_statuses_emp_id_foreign');
			$table->dropForeign('order_statuses_order_id_foreign');
		});
	}

}
