<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_jobs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('applicant_id');
            $table->integer('job_id');
            $table->integer('user_id');
            $table->text('notes')->nullable();
            $table->text('criteria')->nullable();
            $table->string('hired')->default('No');
            $table->string('has_account')->default('No');
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
        Schema::drop('applicant_jobs');
    }
}
