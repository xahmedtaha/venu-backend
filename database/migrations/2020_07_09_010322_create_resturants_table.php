<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resturants', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name_ar', 191);
			$table->string('name_en', 191)->nullable();
			$table->text('description_ar', 65535);
			$table->text('description_en', 65535);
			$table->string('primary_color', 191)->nullable();
			$table->string('accent_color', 191)->nullable();
			$table->float('discount', 10, 0)->nullable();
			$table->string('open_time', 191);
			$table->string('close_time', 191);
			$table->integer('vat_on_total')->default(0);
			$table->float('vat_value', 10, 1)->default(0);
			$table->float('service', 10, 1)->default(0);
			$table->string('phone_number', 191)->nullable();
			$table->integer('is_active')->default(0);
			$table->string('logo', 191);
			$table->softDeletes();
			$table->timestamps();

			// $table->string('place', 191);
			// $table->float('lat', 10, 0);
			// $table->float('long', 10, 0);
			// $table->integer('delivery_time');
			// $table->float('delivery_cost')->default(0.00);
			// $table->bigInteger('place_id')->unsigned();
			// $table->integer('rate')->default(5);
			// $table->integer('rated')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('resturants');
	}

}
