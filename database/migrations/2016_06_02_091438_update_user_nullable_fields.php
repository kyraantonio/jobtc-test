<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user',function(Blueprint $table){
            $table->string('phone')->nullable()->change();
            $table->string('photo')->nullable()->change();
            $table->string('resume')->nullable()->change();
            $table->string('address_1')->nullable()->change();
            $table->string('address_2')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
            $table->string('country_id')->nullable()->change();
            $table->string('skype')->nullable()->change();
            $table->string('facebook')->nullable()->change();
            $table->string('linkedin')->nullable()->change();
            $table->string('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('user',function(Blueprint $table){
            $table->string('phone')->change();
            $table->string('photo')->change();
            $table->string('resume')->change();
            $table->string('address_1')->change();
            $table->string('address_2')->change();
            $table->string('zipcode')->change();
            $table->string('country_id')->change();
            $table->string('skype')->change();
            $table->string('facebook')->change();
            $table->string('linkedin')->change();
            $table->string('notes')->change();
        });
    }
}
