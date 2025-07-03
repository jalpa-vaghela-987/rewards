<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('receiver_id')->index();
            $table->foreignId('card_id')->index();
            $table->foreignId('team_id')->index()->nullable();
            $table->string('display_font')->nullable();
            $table->string('signature_font')->nullable();
            $table->string('signature_name')->nullable();
            $table->text('text')->nullable();
            $table->string('card_type')->default("text");
            $table->text('media_path')->nullable();
            $table->integer('active')->default(0);
            $table->integer('notified')->default(0);
            $table->integer('sent')->default(0);
            $table->integer('emailed')->default(0);
            $table->text('about')->nullable();
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
        Schema::dropIfExists('card_elements');
    }
}
