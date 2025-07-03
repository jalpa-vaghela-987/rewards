<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyToRedemptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->string('currency')->default("USD");
            $table->double('currency_rate',8,2)->default(1);
            $table->double('usd_amount')->nullable();
            $table->integer('kudos_conversion_rate')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->dropColumn(['currency', 'currency_rate', 'usd_amount',"kudos_conversion_rate"]);
        });
    }
}
