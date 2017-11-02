<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHowToVideosTable extends Migration
{
    public function up()
    {
        Schema::create('how_to_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('original_name');
            $table->string('saved_name');
            $table->string('poster_original_name')->nullable();
            $table->string('poster_saved_name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('how_to_videos');
    }
}
