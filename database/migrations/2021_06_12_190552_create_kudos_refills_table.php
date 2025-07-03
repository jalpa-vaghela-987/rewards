<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKudosRefillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kudos_refills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('failed')->default(0);
            $table->integer('success')->default(0);
            $table->integer('type')->default(0);
            $table->dateTime('completed')->nullable();
            
            $table->integer('company_id')->index();

            $table->integer('kudos_refill_freq')->nullable();
            $table->integer('kudos_expiration_freq')->nullable();
            
            $table->integer('level_1_users');
            $table->integer('level_2_users');
            $table->integer('level_3_users');
            $table->integer('level_4_users');
            $table->integer('level_5_users');

            $table->integer('level_1_points_to_give');
            $table->integer('level_2_points_to_give');
            $table->integer('level_3_points_to_give');
            $table->integer('level_4_points_to_give');
            $table->integer('level_5_points_to_give');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kudos_refills');
    }
}
