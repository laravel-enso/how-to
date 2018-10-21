<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHowToTagHowToVideoPivotTable extends Migration
{
    public function up()
    {
        Schema::create('how_to_tag_how_to_video', function (Blueprint $table) {
            $table->integer('how_to_tag_id')->unsigned()->index();
            $table->foreign('how_to_tag_id')->references('id')->on('how_to_tags')
                ->onDelete('cascade');

            $table->integer('how_to_video_id')->unsigned()->index();
            $table->foreign('how_to_video_id')->references('id')->on('how_to_videos')
                ->onDelete('cascade');

            $table->primary(['how_to_tag_id', 'how_to_video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('how_to_tag_how_to_video');
    }
}
