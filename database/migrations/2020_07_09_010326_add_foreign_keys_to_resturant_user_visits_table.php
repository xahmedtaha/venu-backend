<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToResturantUserVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('resturant_user_visits', function(Blueprint $table)
		{
			$table->foreign('resturant_id')->references('id')->on('resturants')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('resturant_user_visits', function(Blueprint $table)
		{
			$table->dropForeign('resturant_user_visits_resturant_id_foreign');
			$table->dropForeign('resturant_user_visits_user_id_foreign');
		});
	}

}
