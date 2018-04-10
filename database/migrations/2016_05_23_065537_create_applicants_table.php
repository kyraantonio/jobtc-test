<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants',function(Blueprint $table){
           $table->increments('id'); 
           $table->integer('job_id');
           $table->string('name');
           $table->string('email');
           $table->string('phone');
           $table->string('resume');
           $table->string('photo');
           $table->string('password');
           $table->string('remember_token');
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
        Schema::drop('applicants');
    }
}
