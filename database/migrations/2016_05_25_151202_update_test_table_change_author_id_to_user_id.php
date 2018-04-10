<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestTableChangeAuthorIdToUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test',function(Blueprint $table) {
           $table->renameColumn('author_id','user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test',function(Blueprint $table) {
           $table->renameColumn('user_id','author_id');
        });
    }
}
