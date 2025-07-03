<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKudosToGiveTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kudos_to_give_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->index();
            $table->integer('kudos_refill_id')->index()->nullable();
            $table->string('note')->nullable();
            $table->string('link')->nullable();
            $table->text('data')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('amount_remaining')->default(0);
            $table->integer('type')->default(0);
            $table->dateTime('expiration')->nullable();
            $table->integer('expired')->default(0);
            $table->string('points_string')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kudos_to_give_transactions');
    }
}
