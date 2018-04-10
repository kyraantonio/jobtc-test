<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePasswordResetsTableAddUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('password_resets', function(Blueprint $table) {
            $table->increments('id')->before('email');
            $table->string('email',50)->change();
            $table->enum('usertype',['applicant','employee']);
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
        Schema::table('password_resets', function(Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
