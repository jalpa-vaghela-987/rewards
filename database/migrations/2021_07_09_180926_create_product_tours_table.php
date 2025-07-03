<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tours', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->index();
            $table->foreignId('company_id')->index();


            $table->integer('visited_kudos_feed')->default(0);
            $table->integer('visited_kudos_give')->default(0);
            $table->integer('visited_wallet')->default(0);
            
            $table->integer('visited_group_cards')->default(0);
            $table->integer('visited_connect')->default(0);
            $table->integer('visited_people')->default(0);

           
            $table->integer('visited_notifications')->default(0);
            $table->integer('visited_profile')->default(0);
            
            $table->integer('visited_activity_dashboard')->default(0);
            $table->integer('visited_billing')->default(0);

            $table->integer('visited_company_settings')->default(0);
            $table->integer('visited_user_settings')->default(0);
            $table->integer('visited_manage_users')->default(0);
            $table->integer('visited_team_settings')->default(0);
            $table->integer('visited_manage_rewards')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tours');
    }
}
