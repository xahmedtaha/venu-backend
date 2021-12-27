<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaiterssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('waiterss', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->string('name', 191);
//            $table->string('email', 191);
//            $table->string('resturant_id', 191);
//            $table->string('branch_id', 191);
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waiterss');
    }
}
