<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTangosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tangos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tango_utid')->index();
            $table->integer('valid')->default(1);
            $table->integer('disabled')->default(1);
            $table->text('currency')->nullable();

            // to mimic rewards below!
            $table->double('min_value',8,2)->default(5);
            $table->double('max_value',8,2)->default(1000);
            $table->integer('issuer_id')->index()->default(0);
            $table->text('title')->nullable(); // items->rewardName
            $table->text('description')->nullable(); // tango short desc
            $table->integer('hidden')->default(0);
            $table->string('photo_path')->nullable();
            $table->text('tango_disclaimer')->nullable();
            $table->text('tango_terms')->nullable();
            $table->text('tango_data')->nullable();
            $table->text('tango_status')->nullable();
            $table->text('tango_description')->nullable();
            $table->text('tango_brand_requirements')->nullable();
            $table->text('tango_redemption_instructions')->nullable();
            $table->integer('active')->default(1); // this means does tango allow it
            $table->string('brand_key')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tangos');
    }
}
