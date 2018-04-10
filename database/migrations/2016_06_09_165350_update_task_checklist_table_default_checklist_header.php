<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTaskChecklistTableDefaultChecklistHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('task_check_list', function (Blueprint $table) {
            $table->string('checklist_header')->nullable()->default('No Title')->change();
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
            $table->string('checklist_header')->nullable()->change();
        });
    }
}
