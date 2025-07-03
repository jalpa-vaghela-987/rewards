<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableInventoryTrackingColumnToRewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->integer('enable_inventory_tracking')->nullable();
            $table->integer('inventory_redeemed')->nullable();
            $table->integer('inventory_confirmed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn('enable_inventory_tracking');
            $table->dropColumn('inventory_redeemed');
            $table->dropColumn('inventory_confirmed');
        });
    }
}
