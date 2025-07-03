<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_configs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->index();
            $table->integer('active')->default(1);
            $table->integer('pause')->default(0);
            $table->integer('left_company')->default(0);
            $table->text('interests')->nullable();
            $table->text('expertise')->nullable();
            $table->text('develop')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('total')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_configs');
    }
}
