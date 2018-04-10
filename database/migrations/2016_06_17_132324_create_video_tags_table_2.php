<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTagsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->nullable;
            $table->bigInteger('applicant_id')->nullable;
            $table->bigInteger('job_id')->nullable;
            $table->bigInteger('video_id')->nullable;
            $table->longText('tags')->nullable;
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
        Schema::drop('video_tags');
    }
}
