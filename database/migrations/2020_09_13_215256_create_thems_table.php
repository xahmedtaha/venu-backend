<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('themes'))
        {
            Schema::create('themes', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 191)->nullable();
                $table->string('drawer_icon_color', 191)->nullable();
                $table->string('app_bar_color', 191)->nullable();
                $table->string('menu_word_color', 191)->nullable();
                $table->string('cart_icon_color', 191)->nullable();
                $table->string('cart_badge_color', 191)->nullable();
                $table->string('cart_badge_text_color', 191)->nullable();
                $table->string('most_selling_text', 191)->nullable();
                $table->string('menu_category_text', 191)->nullable();
                $table->string('slider_picture_selection', 191)->nullable();
                $table->string('price_text_color', 191)->nullable();
                $table->string('action_button_color', 191)->nullable();
                $table->string('selected_navigation_bar_color', 191)->nullable();
                $table->string('unselected_navigation_bar_color', 191)->nullable();
                $table->string('background_color', 191)->nullable();
                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
