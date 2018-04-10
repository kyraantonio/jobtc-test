<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question',function(Blueprint $table){
            $table->text('marking_criteria');
            $table->float('max_point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question',function(Blueprint $table){
            $table->dropColumn('marking_criteria');
            $table->dropColumn('max_point');
        });
    }
}
