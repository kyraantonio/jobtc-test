<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('assignments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('assigned_by');
            $table->string('object_from');
            $table->integer('object_from_id');
            $table->string('object_to');
            $table->integer('object_to_id');
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
        Schema::drop('assignments');
    }
}
