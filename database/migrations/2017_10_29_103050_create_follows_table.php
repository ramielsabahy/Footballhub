<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->integer('follower')->unsigned()->index();
            $table->integer('following')->unsigned()->index();

            $table->foreign('follower')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('following')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['follower', 'following']);
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
        Schema::dropIfExists('follows');
    }
}
