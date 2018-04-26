<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendlyScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendly_scores', function (Blueprint $table) {
            $table->integer('player_id')->unsigned()->index();
            $table->foreign('player_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary('player_id');
            $table->integer('total_points')->default(0);
            $table->integer('total_number_of_played_matches')->default(0);
            $table->integer('number_of_won_matches')->default(0);
            $table->integer('number_of_goals')->default(0);
            $table->integer('number_of_assists')->default(0);
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
        Schema::dropIfExists('friendly_scores');
    }
}
