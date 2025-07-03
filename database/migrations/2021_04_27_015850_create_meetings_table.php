<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user1_id')->index();
            $table->foreignId('user2_id')->index();
            
            $table->dateTime('start')->nullable();
            $table->integer('minutes')->default(30);

            $table->dateTime('reminder_1_sent_at')->nullable();
            $table->dateTime('reminder_2_sent_at')->nullable();
            $table->dateTime('reminder_3_sent_at')->nullable();
            $table->dateTime('reminder_4_sent_at')->nullable();
            $table->dateTime('reminder_5_sent_at')->nullable();
            $table->dateTime('planner_sent_at')->nullable();

            $table->dateTime('user_1_feedback_received')->nullable();
            $table->dateTime('user_2_feedback_received')->nullable();
            $table->text('user_1_feedback')->nullable();
            $table->text('user_2_feedback')->nullable();

            $table->string('user_1_interests')->nullable();
            $table->string('user_2_interests')->nullable();

            $table->string('user_1_expertise')->nullable();
            $table->string('user_2_expertise')->nullable();

            $table->string('user_1_develop')->nullable();
            $table->string('user_2_develop')->nullable();

            $table->foreignId('team_id')->nullable();

            $table->integer('active')->default(1);
            $table->integer('cancelled')->default(0);
            $table->integer('postponed')->default(0);
            $table->dateTime('completed_on')->nullable();

            $table->string('zoom_id')->nullable();
            $table->text('zoom_link')->nullable();
            $table->string('zoom_uuid')->nullable();
            $table->string('zoom_pw')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
