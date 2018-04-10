<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRatesTablePayPeriodToPayPeriodId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rates', function(Blueprint $table) {
            $table->dropColumn('pay_period');
            $table->integer('pay_period_id')->after('currency');
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
             $table->string('pay_period_id')->default('biweekly');
        });
    }
}
