<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTaskCheckListPermissionsTableAddCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_check_list_permissions',function(Blueprint $table) {
            $table->integer('company_id')->after('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_check_list_permissions',function(Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
}
