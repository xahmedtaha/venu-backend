<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->foreign('resturant_id')->references('id')->on('resturants')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE');
			$table->foreign('table_id')->references('id')->on('branch_tables')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('orders_emp_id_foreign');
			$table->dropForeign('orders_resturant_id_foreign');
			$table->dropForeign('orders_user_id_foreign');
		});
	}

}
