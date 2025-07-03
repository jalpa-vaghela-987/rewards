<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id');
            $table->foreignId('user_id');
            $table->string('role')->nullable();
            $table->integer('is_creator')->default(0);
            $table->integer('has_viewed')->default(0);
            $table->integer('has_published')->default(0);
            $table->integer('active')->default(0);
            $table->integer('notified')->default(0);
            $table->integer('removed')->default(0);
            $table->timestamps();

            $table->unique(['card_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_user');
    }
}
