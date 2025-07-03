<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initials', 15)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->rememberToken();
            $table->string('timezone')->nullable();
            $table->foreignId('current_team_id')->nullable();

            $table->text('profile_photo_path')->nullable();
            $table->text('background_photo_path')->nullable();

            $table->string('position')->nullable()->default("Unassigned");
            $table->string('progress')->nullable()->default("Amateur");

            $table->integer('points')->default(0);
            $table->integer('total_points')->default(0);
            $table->integer('points_to_give')->default(0);
            $table->integer('total_points_given')->default(0);

            $table->foreignId('company_id')->nullable();

            $table->integer('role')->default(2);
            $table->integer('level')->default(1);

            $table->integer('developer')->default(0);

            $table->date('birthday')->nullable();
            $table->date('anniversary')->nullable();

            $table->integer('active')->default(1);
            $table->boolean('emails_opt_in')->default(true);
            $table->dateTime('last_login')->nullable();

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
        Schema::dropIfExists('users');
    }
}
