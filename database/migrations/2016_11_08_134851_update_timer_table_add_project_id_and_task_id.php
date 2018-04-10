<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimerTableAddProjectIdAndTaskId extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timer', function(Blueprint $table) {
            $table->integer('project_id')->after('user_id');
            $table->integer('task_id')->after('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timer', function(Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('project_id');
        });
    }
}
