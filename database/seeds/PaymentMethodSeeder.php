<?php

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_method')->insert(array(
            array('payment_method' => 'Credit Card'),
            array('payment_method' => 'Paypal'),
            array('payment_method' => 'Bank Transfer'),
            array('payment_method' => 'Check')
        ));
    }
}
