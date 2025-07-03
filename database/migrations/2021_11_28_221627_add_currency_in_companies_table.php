<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyInCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('default_currency')->default("USD");
            $table->integer('HelloTeam_company')->default(0);
            $table->integer('show_multiple_currencies')->default(1);
            $table->integer('show_rewards')->default(1);
            $table->integer('auto_update_currency')->default(1);
            $table->double('auto_update_currency_kudos_multiply',8,2)->default(1.00);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('default_currency');
            $table->dropColumn('HelloTeam_company');
            $table->dropColumn('show_multiple_currencies');
            $table->dropColumn('show_rewards');
            $table->dropColumn('auto_update_currency');
            $table->dropColumn('auto_update_currency_kudos_multiply');
        });
    }
}
