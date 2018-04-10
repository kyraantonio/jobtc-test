<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('interview_questions', function(Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->text('description');
            $table->text('note');
            $table->integer('score');
            $table->integer('points');
            $table->integer('additional_points');
            $table->time('time_limit');
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
        Schema::drop('interview_questions');
    }
}
