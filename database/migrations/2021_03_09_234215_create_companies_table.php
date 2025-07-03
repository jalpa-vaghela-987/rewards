<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('alias')->nullable();
            $table->string('join_link')->nullable();
            $table->rememberToken();

            $table->text('logo_path')->nullable();//->default("https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/258_Pied_Piper_logo-512.png");
            $table->text('background_path')->nullable();//->default('https://brobible.com/wp-content/uploads/2018/03/silicon-valley-opening-credits-sequence.jpg');

            $table->foreignId('creator_id')->nullable();

            //settings
            //I believe the two items below are no longer used.
            $table->integer('starting_points')->default(500);
            $table->integer('monthly_points_to_give')->default(500); // this is the "current points"

            $table->integer('max_give_amount')->default(1000);
            $table->integer('min_give_amount')->default(100);
            $table->integer('total_points_given')->default(0);

            
            //not really used at the moment...

            //paying details.. not used yet
            $table->integer('package')->default(0);
            $table->integer('paid')->default(0);
            $table->integer('pay_rate')->default(0);
            $table->integer('white_label')->default(0);
            $table->dateTime('trial_start')->nullable();
            $table->dateTime('trial_end')->nullable();
            $table->integer('trial')->default(0);


            $table->integer('in_trial_mode')->default(1);
            $table->integer('using_connect')->default(0);


            $table->integer('level_1_points_to_give')->default(500);
            $table->integer('level_2_points_to_give')->default(2000);
            $table->integer('level_3_points_to_give')->default(5000);
            $table->integer('level_4_points_to_give')->default(7500);
            $table->integer('level_5_points_to_give')->default(10000);

            $table->integer('enable_slack')->default(0);
            $table->text('slack_webhook')->nullable();

            

            //notes
            $table->text('notes')->nullable();

            $table->integer('standard_value')->default(500);
            $table->integer('super_value')->default(1000);

            $table->integer('birthday_value')->default(500);
            $table->integer('anniversary_value')->default(500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
