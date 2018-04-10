<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable2 extends Migration
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
           $table->integer('applicant_id');
           $table->integer('job_id');
           $table->integer('stream_id');
           $table->string('video_type');
           $table->string('video_url');
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
