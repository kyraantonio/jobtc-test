<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareJobsToCompaniesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_jobs_companies_permissions',function(Blueprint $table) {
           $table->increments('id'); 
           $table->integer('company_id');
           $table->integer('user_id');
           $table->integer('job_id');
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
        Schema::drop('share_jobs_companies_permissions');
    }
}
