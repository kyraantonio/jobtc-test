<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRatesTableAddPayPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('rates', function(Blueprint $table) {
            $table->string('pay_period')->after('currency')->default('biweekly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rates', function(Blueprint $table) {
            $table->dropColumn('pay_period');
        });
    }
}
