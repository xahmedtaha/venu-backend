<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BranchItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_items',function (Blueprint $table){
           $table->bigIncrements('id');
           $table->unsignedBigInteger('branch_id');
           $table->unsignedBigInteger('item_id');
           $table->boolean('is_available')->default(true);
           $table->timestamps();

           $table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE');
           $table->foreign('item_id')->references('id')->on('items')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('branch_items');
    }
}
