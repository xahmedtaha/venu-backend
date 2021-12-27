<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMergeTableToBranchTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_tables', function (Blueprint $table) {
            $table->boolean('is_merged_table')->default(false);
            $table->unsignedBigInteger('merged_into')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_tables', function (Blueprint $table) {
            //
        });
    }
}
