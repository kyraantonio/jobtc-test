<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestTableAddCompletionFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test',function(Blueprint $table){
            $table->text('completion_image');
            $table->text('completion_sound');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test',function(Blueprint $table){
            $table->dropColumn('completion_image');
            $table->dropColumn('completion_sound');
        });
    }
}
