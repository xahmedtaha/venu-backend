<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->unsigned()->index('notifications_user_id_foreign');
			$table->integer('type');
			$table->bigInteger('sent_by')->unsigned()->index('notifications_sent_by_foreign');
			$table->timestamps();
			$table->string('title_ar', 191);
			$table->string('title_en', 191);
			$table->text('description_ar', 65535);
			$table->text('description_en', 65535);
			$table->bigInteger('resturant_id')->unsigned()->nullable()->index('notifications_resturant_id_foreign');
			$table->string('link', 191)->nullable();
			$table->bigInteger('order_id')->unsigned()->nullable()->index('notifications_order_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
