<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('rates', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('rate_type')->default('hourly');
            $table->string('rate_value')->default(0);
            $table->string('currency')->default('PHP');
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
        Schema::drop('rates');
    }
}
