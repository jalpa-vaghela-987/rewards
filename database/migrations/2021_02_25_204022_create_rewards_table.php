<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->integer('cost')->default(0);
            $table->double('min_value',8,2)->default(5);
            $table->double('max_value',8,2)->default(1000);
            $table->double('value',8,2)->default(0);
            $table->string('type')->default("default");
            $table->integer('issuer_id')->index()->default(0);
            $table->text('title')->nullable(); // items->rewardName
            $table->text('description')->nullable(); // tango short desc
            $table->integer('hidden')->default(0);
            $table->integer('remaining_amount')->default(100);
            $table->string('photo_path')->nullable();

            $table->integer('active')->default(1);

           


            $table->text('tango_disclaimer')->nullable();
            $table->text('tango_terms')->nullable();
            $table->text('tango_data')->nullable();
            $table->text('tango_status')->nullable();
            $table->text('tango_description')->nullable();
            $table->text('tango_brand_requirements')->nullable();
            $table->text('tango_redemption_instructions')->nullable();

            // to integrate with tango
            $table->string('brand_key')->nullable();
            $table->string('tango_utid')->nullable();

            //adding in custom rewards 6-15-2021
            $table->integer('is_custom')->default(0);
            $table->integer('required_authorization')->default(0);
            $table->integer('company_id')->index()->nullable();
            $table->foreignId('creator_id')->index()->nullable();
            $table->text('custom_redemption_instructions')->nullable();
            $table->text('expected_timeframe')->nullable();
            $table->integer('require_verification')->default(0);
            $table->integer('is_digital')->default(0);
            $table->integer('stock_amount')->default(0);
            $table->integer('use_set_amount')->default(0);
            $table->integer('min_kudos_value')->default(0);
            $table->integer('max_kudos_value')->default(100000);
            $table->integer('kudos_conversion_rate')->default(100);
            $table->integer('disabled')->default(0);


            // three people can redeem these... (might make it all admins, still unsure.)
            $table->foreignId('admin_id')->index()->nullable();
            $table->foreignId('alt_admin_id')->index()->nullable();
            $table->foreignId('alt3_admin_id')->index()->nullable();







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
        Schema::dropIfExists('rewards');
    }
}
