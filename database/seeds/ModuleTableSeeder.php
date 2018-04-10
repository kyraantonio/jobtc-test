<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //For Projects Module
        $project_module_count = Module::where('name', 'Projects')->count();
        if ($project_module_count === 0) {
            $project_module = new Module();
            $project_module->name = 'Projects';
            $project_module->save();
        }
        
        //For Briefcases Module
        $briefcase_module_count = Module::where('name', 'Briefcases')->count();
        if ($briefcase_module_count === 0) {
            $briefcase_module_count = new Module();
            $briefcase_module_count->name = 'Briefcases';
            $briefcase_module_count->save();
        }
        
        //For Task Items Module
        $task_items_module_count = Module::where('name', 'Task Items')->count();
        if ($task_items_module_count === 0) {
            $task_items_module_count = new Module();
            $task_items_module_count->name = 'Task Items';
            $task_items_module_count->save();
        }
        
        //For Jobs Module
        $jobs_module_count = Module::where('name', 'Jobs')->count();
        if ($jobs_module_count === 0) {
            $jobs_module = new Module();
            $jobs_module->name = 'Jobs';
            $jobs_module->save();
        }
        //For Applicants Module
        $applicants_module_count = Module::where('name', 'Applicants')->count();
        if ($applicants_module_count === 0) {
            $applicants_module = new Module();
            $applicants_module->name = 'Applicants';
            $applicants_module->save();
        }

        //For Employees Module
        $employees_module_count = Module::where('name', 'Employees')->count();
        if ($employees_module_count === 0) {
            $employees_module = new Module();
            $employees_module->name = 'Employees';
            $employees_module->save();
        }

        //For Tests Module
        $tests_module_count = Module::where('name', 'Tests')->count();
        if ($tests_module_count === 0) {
            $tests_module = new Module();
            $tests_module->name = 'Tests';
            $tests_module->save();
        }

        //For Role Module
        $roles_module_count = Module::where('name', 'Positions')->count();
        if ($roles_module_count === 0) {
            $positions_module = new Module();
            $positions_module->name = 'Positions';
            $positions_module->save();
        }
        
        //For Tickets Module
        $tickets_module_count = Module::where('name', 'Tickets')->count();
        if ($tickets_module_count === 0) {
            $tickets_module = new Module();
            $tickets_module->name = 'Tickets';
            $tickets_module->save();
        }

        //For Links Module
        $links_module_count = Module::where('name', 'Links')->count();
        if ($links_module_count === 0) {
            $links_module_count = new Module();
            $links_module_count->name = 'Links';
            $links_module_count->save();
        }

        
    }

}
