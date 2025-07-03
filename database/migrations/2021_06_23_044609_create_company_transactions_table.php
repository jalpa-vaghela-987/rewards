<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->index()->nullable();
            $table->integer('company_id')->index();

            $table->string('note')->nullable();
            $table->string('link')->nullable();
            $table->text('data')->nullable();
            $table->double('amount',8,2)->default(0);
            
            $table->integer('type')->default(0);
            $table->dateTime('expiration')->nullable();

            $table->integer('active')->default(0);
            $table->integer('failed_transaction')->default(0);
            $table->integer('is_subscription')->default(0);
            $table->integer('freq_days')->default(0);
            $table->timestamp('transaction_sucessful')->nullable();
            $table->integer('refunded')->default(0);
            $table->text('stripe_data')->nullable();

            $table->text('hash')->nullable();
            $table->dateTime('hash_expiration')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_transactions');
    }
}
