<?php

use Illuminate\Database\Seeder;

class QuestionTypeSeederNewType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_type')->insert(array(
            array('type' => 'Video Question')
        ));
    }
}
