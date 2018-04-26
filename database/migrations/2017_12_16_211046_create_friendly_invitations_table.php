<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendlyInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendly_invitations', function (Blueprint $table) {
            $table->integer('player_id')->unsigned()->index();
            $table->integer('friendly_match_id')->unsigned()->index();
            $table->foreign('player_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('friendly_match_id')->references('id')->on('friendly_matches')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['player_id', 'friendly_match_id']);
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
        Schema::dropIfExists('friendly_invitations');
    }
}
