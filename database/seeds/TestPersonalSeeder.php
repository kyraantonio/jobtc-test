<?php

use Illuminate\Database\Seeder;

class TestPersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test = DB::table('test')->orderBy('order','ASC')->get();

        if(count($test) > 0){
            foreach($test as $v){
                DB::table('test_personal')
                    ->insert([
                        'test_id' => $v->id,
                        'user_id' => $v->user_id,
                        'order' => $v->order,
                        'version' => 1,
                        'parent_test_id' => $v->id
                    ]);
            }
        }
    }
}
