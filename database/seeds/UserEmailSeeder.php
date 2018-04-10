<?php

use Illuminate\Database\Seeder;

class UserEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')
            ->whereNull('name')
            ->orWhere('name', '')
            ->update([
                'name' => DB::raw('fp_user.username')
            ]);
        DB::table('user')
            ->whereNull('email')
            ->orWhere('email', '')
            ->update([
                'email' => 'jobtcmailer@gmail.com'
            ]);
    }
}
