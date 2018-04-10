<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTaskCheckListTableUpdateChecklistHeaderAndChecklistContentToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_check_list', function (Blueprint $table) {
            $table->string('checklist_header')->nullable()->change();
            $table->text('checklist')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_check_list', function (Blueprint $table) {
            $table->string('checklist_header')->change();
            $table->text('checklist')->change();
        });
    }
}
