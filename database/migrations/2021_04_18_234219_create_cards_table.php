<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();

            $table->timestamps();
            $table->foreignId('creator_id')->index();
            $table->foreignId('receiver_id')->index();
            $table->foreignId('team_id')->nullable();

            $table->string('headline');
            $table->string('display_name');
            $table->string('card_type');
            $table->string('email');
            $table->dateTime('send_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->string('background_photo_path')->nullable();
            $table->string('banner_color')->nullable();
            $table->string('banner_font')->nullable();
            $table->integer('active')->default(1);
            $table->integer('in_progress')->default(0);
            $table->integer('sent_to_contributors')->default(0);
            $table->integer('sent_to_recipient')->default(0);
            $table->integer('recipient_viewed')->default(0);
            $table->integer('theme')->default(0);
            $table->integer('custom_theme')->default(0);

            $table->text('hash')->nullable();

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
