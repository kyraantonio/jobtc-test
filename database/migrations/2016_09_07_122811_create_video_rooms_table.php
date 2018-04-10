<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoRoomsTable extends Migration
{
  /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('video_rooms', function(Blueprint $table) {
            $table->increments('id');
            $table->string('session_id');
            $table->string('nfo_id');
            $table->string('room_name');
            $table->string('room_type');
            $table->string('stream');
            $table->string('rec_dir');
            $table->string('stream_start');
            $table->string('stream_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('video_rooms');
    }
}
