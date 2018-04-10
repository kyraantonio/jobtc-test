<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('payroll', function(Blueprint $table) {
            $table->increments('id');
            $table->string('profile_id');
            $table->string('month');
            $table->string('year');
            $table->string('pay_period');
            $table->string('start_period');
            $table->string('end_period');
            $table->string('due');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('payroll');
    }

}
