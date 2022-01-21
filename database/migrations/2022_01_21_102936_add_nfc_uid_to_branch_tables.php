<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNfcUidToBranchTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_tables', function (Blueprint $table) {
            $table->string('nfc_uid')->nullable()->unique();
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
            if (Schema::hasColumn('branch_tables', 'nfc_uid')) {
                $table->dropColumn('nfc_uid');
            }
        });
    }
}
