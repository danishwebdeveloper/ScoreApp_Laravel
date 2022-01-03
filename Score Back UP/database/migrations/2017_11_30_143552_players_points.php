<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayersPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id');
            $table->integer('test_id');
            $table->integer('exercise_id');
            $table->integer('points');
            $table->float('level');
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
        Schema::dropIfExists('players_points');
    }
}
