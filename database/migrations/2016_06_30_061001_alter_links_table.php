<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('links',function(Blueprint $table) {
            $table->integer('company_id')->after('task_id');
            $table->integer('user_id')->after('company_id');
            $table->integer('task_item_id')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('links',function(Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('user_id');
            $table->dropColumn('task_item_id');
        });
    }
}
