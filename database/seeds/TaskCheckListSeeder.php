<?php

use Illuminate\Database\Seeder;
use App\Models\TaskChecklist;

class TaskCheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task_checklist = TaskChecklist::where('status','');
        
        $task_checklist->update([
            'status' => 'Default'
        ]);
        
    }
}
