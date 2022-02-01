<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laravel-invitations.database.invitations_table'), function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->string('email');
            $table->morphs('invitee');
            $table->enum('status', ['pending', 'accepted', 'canceled', 'expired'])->default('pending');
            $table->timestamp('expires_at');
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
        Schema::drop(config('laravel-invitations.database.invitations_table'));
    }
}
