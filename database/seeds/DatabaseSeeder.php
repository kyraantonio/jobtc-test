<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //comment for now because seeding this is not required
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MeetingSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(AccountsSeeder::class);

        Model::reguard();
    }
}
