<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserFeedbacksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_feedbacks', function(Blueprint $table)
		{
			$table->foreign('reason_id', 'user_feedback_reason_id_foreign')->references('id')->on('user_feedback_reasons')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('resturant_id', 'user_feedback_resturant_id_foreign')->references('id')->on('resturants')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'user_feedback_user_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_feedbacks', function(Blueprint $table)
		{
			$table->dropForeign('user_feedback_reason_id_foreign');
			$table->dropForeign('user_feedback_resturant_id_foreign');
			$table->dropForeign('user_feedback_user_id_foreign');
		});
	}

}
