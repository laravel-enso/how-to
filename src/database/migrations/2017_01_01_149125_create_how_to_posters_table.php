<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHowToPostersTable extends Migration
{
    public function up()
    {
        Schema::create('how_to_posters', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('video_id')->unsigned()->index();
            $table->foreign('video_id')->references('id')->on('how_to_videos');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('how_to_posters');
    }
}
