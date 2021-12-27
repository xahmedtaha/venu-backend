<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRequestingCheckoutToBranchTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_tables', function (Blueprint $table) {
            $table->boolean('is_requesting_checkout')->default(0);
            $table->boolean('is_calling_waiter')->default(0);
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
            if (Schema::hasColumn('branch_tables', 'is_requesting_checkout')) {
                $table->dropColumn('is_requesting_checkout');
            }
            if (Schema::hasColumn('branch_tables', 'is_calling_waiter')) {
                $table->dropColumn('is_calling_waiter');
            }
        });
    }
}
