<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PointsToLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_to_level', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id');
            $table->integer('exercise_id');
            $table->string('gender');
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
        Schema::dropIfExists('points_to_level');
    }
}
