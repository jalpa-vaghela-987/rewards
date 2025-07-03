<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->double('balance',8,2)->default(0);

            $table->double('cumulative_balance',8,2)->default(0);
            $table->double('last_added_balance',8,2)->default(0);

            $table->double('cumulative_balance_spent',8,2)->default(0);
            $table->double('last_balance_spent',8,2)->default(0);

            $table->double('forfeited_balance',8,2)->default(0);
            $table->double('refund_balance',8,2)->default(0);

            $table->timestamp('balance_updated')->nullable();

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
            $table->dropColumn('balance');

            $table->dropColumn('cumulative_balance');
            $table->dropColumn('last_added_balance');

            $table->dropColumn('cumulative_balance_spent');
            $table->dropColumn('last_balance_spent');

            $table->dropColumn('forfeited_balance');
            $table->dropColumn('refund_balance');

            $table->dropColumn('balance_updated');
        });
    }
}
