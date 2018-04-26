<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchMapTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_map_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competition_season_id')->unsigned()->index();
            $table->integer('group_A');
            $table->char('team_A');
            $table->integer('group_B');
            $table->char('team_B');
            $table->foreign('competition_season_id')->references('Id')->on('CompetitionSeason')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('match_map_teams');
    }
}
