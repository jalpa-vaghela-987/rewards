<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedemptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('reward_id')->index();
            $table->text('data')->nullable();
            $table->integer('refund')->default(0);
            $table->integer('active')->default(0);
            $table->integer('hidden')->default(0);
            $table->integer('completed')->default(0);
            $table->double('value', 8, 2)->default(0.00);//in dollars
            $table->integer('cost')->default(0);//in points

            $table->text('redemption_instructions')->nullable();
            $table->text('redemption_code')->nullable();

            //tango below
            
            $table->string('tango_order_id')->nullable();
            $table->string('tango_customer_id')->nullable();
            $table->string('tango_account_id')->nullable();
            $table->string('tango_created_at')->nullable();
            $table->string('tango_status')->nullable();
            $table->string('tango_amount')->nullable();
            $table->string('tango_utid')->nullable();
            $table->string('tango_reward_name')->nullable();
            $table->string('tango_notes')->nullable();
            $table->text('tango_directions')->nullable();

            $table->text('tango_disclaimer')->nullable();
            $table->text('tango_terms')->nullable();
            $table->text('tango_data')->nullable();
            $table->text('tango_brand_requirements')->nullable();


            // different tango redemption methods
            $table->string('tango_link')->nullable();
            $table->string('tango_claim_code')->nullable();
            $table->string('tango_pin')->nullable();
            $table->string('tango_card_number')->nullable();

            //custom rewards
            $table->integer('is_custom')->default(0);
            $table->integer('marked_as_sent')->default(0);
            $table->integer('reminder_1_sent')->default(0);
            $table->integer('reminder_2_sent')->default(0);
            $table->integer('confirmed_reciept')->default(0);
            $table->integer('reward_forfeited')->default(0);
            $table->integer('marked_as_unable_to_furfill')->default(0);
            $table->integer('refund_sent')->default(0);
            




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redemptions');
    }
}
