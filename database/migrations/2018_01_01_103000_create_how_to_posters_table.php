<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('how_to_posters', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('video_id')->unsigned()->index();
            $table->foreign('video_id')->references('id')->on('how_to_videos');

            $table->bigInteger('file_id')->unsigned()->nullable()->unique();
            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('restrict')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('how_to_posters');
    }
};
