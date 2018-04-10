<?php

use Illuminate\Database\Seeder;

class PayPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payroll_pay_periods')->insert([
            'period' => 'biweekly',
            'default' => 'Friday,Friday'
        ]);
        
        DB::table('payroll_pay_periods')->insert([
            'period' => 'weekly',
            'default' => 'Friday'
        ]);
        
        DB::table('payroll_pay_periods')->insert([
            'period' => 'monthly',
            'default' => '30'
        ]);
        
        DB::table('payroll_pay_periods')->insert([
            'period' => 'semi-monthly',
            'default' => '30,30'
        ]);
    }
}
