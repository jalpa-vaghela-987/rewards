<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->index();
            $table->integer('point_id')->index()->nullable();
            $table->integer('redemption_id')->index()->nullable();
            $table->integer('refill_id')->index()->nullable();
            $table->string('note')->nullable();
            $table->string('link')->nullable();
            $table->text('data')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('type')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
