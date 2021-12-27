<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('order_id');
            $table->float('unit_price');
            $table->integer('quantity');
            $table->float('sub_total');
            $table->float('total');
            $table->string('hash')->nullable();
            $table->integer('state')->comment('0: in Cart, 1: in order')->default(0);
            $table->boolean('is_in_kitchen')->default(false);
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
        Schema::dropIfExists('ordered_items');
    }
}
