<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos',function(Blueprint $table) {
           $table->increments('id');
           $table->integer('unique_id');
           $table->string('user_type');
           $table->integer('owner_id');
           $table->string('owner_type');
           $table->string('stream_id');
           $table->string('video_type');
           $table->string('video_url');
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
        Schema::drop('videos');
    }
}
