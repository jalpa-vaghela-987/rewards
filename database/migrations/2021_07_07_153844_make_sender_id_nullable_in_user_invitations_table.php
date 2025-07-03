<?php

use Illuminate\Database\Migrations\Migration;

class MakeSenderIdNullableInUserInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE user_invitations MODIFY sender_id bigint(20) unsigned DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE user_invitations MODIFY sender_id bigint(20) unsigned NOT NULL');
    }
}
