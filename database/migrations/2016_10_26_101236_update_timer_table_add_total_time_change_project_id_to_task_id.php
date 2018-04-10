<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimerTableAddTotalTimeChangeProjectIdToTaskId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timer', function(Blueprint $table) {
            $table->renameColumn('project_id','task_checklist_id');
            $table->dropColumn('username');
            $table->string('total_time')->nullable()->after('end_time');
            $table->integer('user_id')->after('timer_id');
            $table->string('timer_status')->after('total_time');
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
            $table->renameColumn('task_checklist_id','project_id');
            $table->string('username')->after('timer_id');
            $table->dropColumn('total_time');
            $table->dropColumn('user_id');
            $table->dropColumn('timer_status');
        });
    }
}
