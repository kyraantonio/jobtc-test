<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoSessionsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('video_sessions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('session_id');
            $table->string('unique_id');
            $table->string('owner_type');
            $table->string('total_time');
            $table->string('is_recording');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('video_sessions');
    }
}
