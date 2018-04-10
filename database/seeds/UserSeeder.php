<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminRole = \Bican\Roles\Models\Role::where('name','=','Admin')->first();
        $clientRole = \Bican\Roles\Models\Role::where('name','=','Client')->first();
        $staffRole = \Bican\Roles\Models\Role::where('name','=','Client')->first();


        $user = new \App\Models\User();
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->user_status = 'Active';
        $user->save();
        $user->attachRole($adminRole);
        $user->save();

        $staffClient = new \App\Models\User();
        $staffClient->username = 'staff';
        $staffClient->password = bcrypt('staff');
        $staffClient->user_status = 'Active';
        $staffClient->save();
        $staffClient->attachRole($staffRole);
        $staffClient->save();

        $userClient = new \App\Models\User();
        $userClient->username = 'client';
        $userClient->password = bcrypt('client');
        $userClient->user_status = 'Active';
        $userClient->save();
        $userClient->attachRole($clientRole);
        $userClient->save();

    }
}
