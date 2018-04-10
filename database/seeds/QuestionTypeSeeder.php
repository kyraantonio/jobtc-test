<?php

use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_type')->insert(array(
            array('type' => 'Multiple Choice'),
            array('type' => 'Fill in the Blank'),
            array('type' => 'Written Answer')
        ));

    }
}
