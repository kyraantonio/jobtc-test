<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_question_answers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->string('module_type');
            $table->integer('module_id');
            $table->integer('video_id');
            $table->double('score', 8, 2)->nullable();
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
        Schema::drop('interview_question_answers');
    }
}
