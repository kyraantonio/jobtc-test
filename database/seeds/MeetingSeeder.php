<?php

use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meeting_type')->insert(array(
            array('type' => 'In Person'),
            array('type' => 'Online'),
            array('type' => 'Telephone')
        ));

        DB::table('meeting_priority')->insert(array(
            array('priority' => 'Normal'),
            array('priority' => 'Urgent')
        ));
    }
}
