<?php

use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert(array(
            array(
                'account_name' => 'Sample Account Name',
                'currency' => 'USD',
                'payment_method_id' => 2
            )
        ));
    }
}
