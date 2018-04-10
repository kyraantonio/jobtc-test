<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('applicant_tags',function(Blueprint $table){
           $table->increments('id'); 
           $table->integer('user_id'); 
           $table->integer('applicant_id'); 
           $table->integer('job_id'); 
           $table->string('tags'); 
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
        Schema::drop('applicant_tags');
    }
}
