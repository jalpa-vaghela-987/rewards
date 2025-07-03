<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVimeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vimeos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->index();
            $table->integer('card_element_id')->index();
            
            $table->string('url')->nullable();
            $table->string('vim_id')->nullable();
            $table->string('ticket_id')->nullable();
            $table->string('upload_link')->nullable();
            $table->string('redirect')->nullable();
            $table->string('download_link_sd')->nullable();
            $table->string('download_link_hd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vimeos');
    }
}
