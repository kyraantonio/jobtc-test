<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_tags',function(Blueprint $table) {
           $table->increments('id'); 
           $table->integer('user_id');
           $table->integer('applicant_id');
           $table->integer('job_id');
           $table->string('video_id');
           $table->string('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('video_tags');
    }
}
