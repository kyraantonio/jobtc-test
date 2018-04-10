<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_completed',function(Blueprint $table){
            $table->increments('id');
            $table->integer('test_id');
            $table->integer('unique_id');
            $table->string('belongs_to');
            $table->string('score');
            $table->string('total_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('test_completed');
    }
}
