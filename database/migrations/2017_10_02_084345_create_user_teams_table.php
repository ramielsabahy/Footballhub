<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_teams', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('team_id')->unsigned()->index();
            $table->boolean('join_request')->default(false);
            $table->boolean('invitation_request')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->primary('user_id', 'team_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_teams');
    }
}
