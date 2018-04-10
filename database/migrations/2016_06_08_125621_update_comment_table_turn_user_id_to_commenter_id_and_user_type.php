<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommentTableTurnUserIdToCommenterIdAndUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('comment',function(Blueprint $table){
             $table->string('commenter_type')->after('user_id');
             $table->renameColumn('user_id','commenter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('comment',function(Blueprint $table){
            $table->renameColumn('commenter_id','user_id');
            $table->dropColumn('commenter_type');
        });
    }
}
