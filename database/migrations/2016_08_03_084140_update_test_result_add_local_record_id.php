<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTestResultAddLocalRecordId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_result',function(Blueprint $table) {
            $table->string('local_record_id')->after('answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_result',function(Blueprint $table) {
            $table->dropColumn('local_record_id');
        });
    }
}
