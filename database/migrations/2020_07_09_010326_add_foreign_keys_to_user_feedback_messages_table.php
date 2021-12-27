<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserFeedbackMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_feedback_messages', function(Blueprint $table)
		{
			$table->foreign('user_feedback_id')->references('id')->on('user_feedbacks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_feedback_messages', function(Blueprint $table)
		{
			$table->dropForeign('user_feedback_messages_user_feedback_id_foreign');
		});
	}

}
