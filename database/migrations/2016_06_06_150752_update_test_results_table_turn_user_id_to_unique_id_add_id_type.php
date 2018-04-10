<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestResultsTableTurnUserIdToUniqueIdAddIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_result',function(Blueprint $table){
            $table->string('belongs_to')->after('user_id');
            $table->renameColumn('user_id','unique_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_result',function(Blueprint $table){
            $table->renameColumn('unique_id','user_id');
            $table->dropColumn('belongs_to');
        });
    }
}
