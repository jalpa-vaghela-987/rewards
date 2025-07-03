<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKudoRefillFrequencyToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('kudos_refill_freq')->default(30);
            $table->integer('kudos_expiration_freq')->default(32);
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
            $table->dropColumn('kudos_refill_freq');
            $table->dropColumn('kudos_expiration_freq');
        });
    }
}
