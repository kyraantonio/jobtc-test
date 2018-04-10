<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTableAddResumeAndNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user',function(Blueprint $table){
            $table->string('notes')->after('user_status');
            $table->string('resume')->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants',function(Blueprint $table){
            $table->dropColumn('notes');
            $table->dropColumn('resume');
        });
    }
}
