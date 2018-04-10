<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('discussions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->integer('company_id');
            $table->string('room_name');
            $table->string('room_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('discussions');
    }
}
