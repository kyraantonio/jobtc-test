<?php

use Illuminate\Database\Seeder;
use App\Models\Test;

class PermissionTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert(array(
            array(
                'name' => 'Questions'
            )
        ));

        DB::table('permissions')->insert(array(
            array(
                'name' => 'Drag Tests',
                'slug' => 'drag.tests',
                'description' => 'Tests',
                'model' => 'App\Models\Test',
            ),
            array(
                'name' => 'Create Questions',
                'slug' => 'create.questions',
                'description' => 'Questions',
                'model' => 'App\Models\Question',
            ),
            array(
                'name' => 'Edit Questions',
                'slug' => 'edit.questions',
                'description' => 'Questions',
                'model' => 'App\Models\Question',
            ),
            array(
                'name' => 'Delete Questions',
                'slug' => 'delete.questions',
                'description' => 'Questions',
                'model' => 'App\Models\Question',
            ),
            array(
                'name' => 'Drag Questions',
                'slug' => 'drag.questions',
                'description' => 'Questions',
                'model' => 'App\Models\Question',
            )
        ));

        $test = DB::table('test')
            ->select('test.id', 'test.user_id', 'roles.company_id')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'test.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->whereNull('test.company_id')
            ->get();
        if(count($test) > 0){
            foreach($test as $v){
                $t = Test::find($v->id);
                $t->company_id = $v->company_id;
                $t->save();
            }
        }
    }
}
