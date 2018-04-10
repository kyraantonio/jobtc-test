<?php

use Illuminate\Database\Seeder;

class TicketItAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')
        ->where('user_id', 6)
        ->update([
                'ticketit_admin' => 1
        ]);
    }
}
