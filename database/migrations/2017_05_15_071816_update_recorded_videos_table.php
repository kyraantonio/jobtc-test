<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecordedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recorded_videos', function ($table) {
            $table->string('recorded_by');
            $table->integer('user_id');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('recorded_videos', function ($table) {
            $table->dropColumn('recorded_by');
            $table->dropColumn('user_id');
            $table->dropColumn('description');
        });
    }
}
