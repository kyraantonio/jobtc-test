<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Permission;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Permissions for Projects
        $viewProjectPermissionCount = Permission::where('slug', 'view.projects')->count();
        if ($viewProjectPermissionCount === 0) {
            $viewProjectPermission = Permission::create([
                        'name' => 'View Projects',
                        'slug' => 'view.projects',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        $createProjectPermissionCount = Permission::where('slug', 'create.projects')->count();
        if ($createProjectPermissionCount === 0) {
            $createProjectPermission = Permission::create([
                        'name' => 'Create Projects',
                        'slug' => 'create.projects',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }
        $editProjectPermissionCount = Permission::where('slug', 'edit.projects')->count();
        if ($editProjectPermissionCount === 0) {
            $editProjectPermission = Permission::create([
                        'name' => 'Edit Projects',
                        'slug' => 'edit.projects',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }
        $deleteProjectPermissionCount = Permission::where('slug', 'delete.projects')->count();
        if ($deleteProjectPermissionCount === 0) {
            $deleteProjectPermission = Permission::create([
                        'name' => 'Delete Projects',
                        'slug' => 'delete.projects',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        $assignProjectPermissionCount = Permission::where('slug', 'assign.projects')->count();
        if ($assignProjectPermissionCount === 0) {
            $assignProjectPermission = Permission::create([
                        'name' => 'Assign Projects',
                        'slug' => 'assign.projects',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        //Permissions for Briefcases
        $createBriefCasePermissionCount = Permission::where('slug', 'create.briefcases')->count();
        if ($createBriefCasePermissionCount === 0) {
            $createBriefCasePermission = Permission::create([
                        'name' => 'Create Briefcases',
                        'slug' => 'create.briefcases',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        $editBriefCasePermissionCount = Permission::where('slug', 'edit.briefcases')->count();
        if ($editBriefCasePermissionCount === 0) {
            $editBriefCasePermission = Permission::create([
                        'name' => 'Edit Briefcases',
                        'slug' => 'edit.briefcases',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        $deleteBriefCasePermissionCount = Permission::where('slug', 'delete.briefcases')->count();
        if ($deleteBriefCasePermissionCount === 0) {
            $deleteBriefCasePermission = Permission::create([
                        'name' => 'Delete Briefcases',
                        'slug' => 'delete.briefcases',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Project'
            ]);
        }

        //Permissions for Task List Items
        $createTaskListItemsPermissionCount = Permission::where('slug', 'create.tasks')->count();
        if ($createTaskListItemsPermissionCount === 0) {
            $createTaskListItemsPermission = Permission::create([
                        'name' => 'Create Tasks',
                        'slug' => 'create.tasks',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Task'
            ]);
        }

        $editTaskListItemsPermissionCount = Permission::where('slug', 'edit.tasks')->count();
        if ($editTaskListItemsPermissionCount === 0) {
            $editTaskListItemsPermission = Permission::create([
                        'name' => 'Edit Tasks',
                        'slug' => 'edit.tasks',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Task'
            ]);
        }

        $deleteTaskListItemsPermissionCount = Permission::where('slug', 'delete.tasks')->count();
        if ($deleteTaskListItemsPermissionCount === 0) {
            $deleteTaskListItemsPermission = Permission::create([
                        'name' => 'Delete Tasks',
                        'slug' => 'delete.tasks',
                        'description' => 'Projects', // optional
                        'model' => 'App\Models\Task'
            ]);
        }


        //Permissions for Jobs
        $viewJobPermissionCount = Permission::where('slug', 'view.jobs')->count();
        if ($viewJobPermissionCount === 0) {
            $viewJobPermission = Permission::create([
                        'name' => 'View Jobs',
                        'slug' => 'view.jobs',
                        'description' => 'Jobs', // optional
                        'model' => 'App\Models\Job'
            ]);
        }

        $createJobPermissionCount = Permission::where('slug', 'create.jobs')->count();
        if ($createJobPermissionCount === 0) {
            $createJobPermission = Permission::create([
                        'name' => 'Create Jobs',
                        'slug' => 'create.jobs',
                        'description' => 'Jobs', // optional
                        'model' => 'App\Models\Job'
            ]);
        }

        $editJobPermissionCount = Permission::where('slug', 'edit.jobs')->count();
        if ($editJobPermissionCount === 0) {
            $editJobPermission = Permission::create([
                        'name' => 'Edit Jobs',
                        'slug' => 'edit.jobs',
                        'description' => 'Jobs', // optional
                        'model' => 'App\Models\Job'
            ]);
        }

        $deleteJobPermissionCount = Permission::where('slug', 'delete.jobs')->count();
        if ($deleteJobPermissionCount === 0) {
            $deleteJobPermission = Permission::create([
                        'name' => 'Delete Jobs',
                        'slug' => 'delete.jobs',
                        'description' => 'Jobs', // optional
                        'model' => 'App\Models\Job'
            ]);
        }

        $shareJobPermissionCount = Permission::where('slug', 'assign.jobs')->count();
        if ($shareJobPermissionCount === 0) {
            $shareJobPermission = Permission::create([
                        'name' => 'Assign Jobs',
                        'slug' => 'assign.jobs',
                        'description' => 'Jobs', // optional
                        'model' => 'App\Models\Job'
            ]);
        }
        //Permissions for Employees
        $viewEmployeesPermissionCount = Permission::where('slug', 'view.employees')->count();
        if ($viewEmployeesPermissionCount === 0) {
            $viewEmployeesPermission = Permission::create([
                        'name' => 'View Employees',
                        'slug' => 'view.employees',
                        'description' => 'Employees', // optional
                        'model' => 'App\Models\User'
            ]);
        }

        $createEmployeesPermissionCount = Permission::where('slug', 'create.employees')->count();
        if ($createEmployeesPermissionCount === 0) {
            $createEmployeesPermission = Permission::create([
                        'name' => 'Create Employees',
                        'slug' => 'create.employees',
                        'description' => 'Employees', // optional
                        'model' => 'App\Models\User'
            ]);
        }

        $editEmployeesPermissionCount = Permission::where('slug', 'edit.employees')->count();
        if ($editEmployeesPermissionCount === 0) {
            $editEmployeesPermission = Permission::create([
                        'name' => 'Edit Employees',
                        'slug' => 'edit.employees',
                        'description' => 'Employees', // optional
                        'model' => 'App\Models\User'
            ]);
        }

        $removeEmployeesPermissionCount = Permission::where('slug', 'remove.employees')->count();
        if ($removeEmployeesPermissionCount === 0) {
            $removeEmployeesPermission = Permission::create([
                        'name' => 'Remove Employees',
                        'slug' => 'remove.employees',
                        'description' => 'Employees', // optional
                        'model' => 'App\Models\User'
            ]);
        }

        //Permissions for Tests
        $viewTestPermissionCount = Permission::where('slug', 'view.tests')->count();
        if ($viewTestPermissionCount === 0) {
            $viewTestPermission = Permission::create([
                        'name' => 'View Tests',
                        'slug' => 'view.tests',
                        'description' => 'Tests', // optional
                        'model' => 'App\Models\Test'
            ]);
        }

        $createTestPermissionCount = Permission::where('slug', 'create.tests')->count();
        if ($createTestPermissionCount === 0) {
            $createTestPermission = Permission::create([
                        'name' => 'Create Tests',
                        'slug' => 'create.tests',
                        'description' => 'Tests', // optional
                        'model' => 'App\Models\Test'
            ]);
        }

        $editTestPermissionCount = Permission::where('slug', 'edit.tests')->count();
        if ($editTestPermissionCount === 0) {
            $editTestPermission = Permission::create([
                        'name' => 'Edit Tests',
                        'slug' => 'edit.tests',
                        'description' => 'Tests', // optional
                        'model' => 'App\Models\Test'
            ]);
        }

        $deleteTestPermissionCount = Permission::where('slug', 'delete.tests')->count();
        if ($deleteTestPermissionCount === 0) {
            $deleteTestPermission = Permission::create([
                        'name' => 'Delete Tests',
                        'slug' => 'delete.tests',
                        'description' => 'Tests', // optional
                        'model' => 'App\Models\Test'
            ]);
        }

        $assignTestPermissionCount = Permission::where('slug', 'assign.tests')->count();
        if ($assignTestPermissionCount === 0) {
            $assignTestPermission = Permission::create([
                        'name' => 'Assign Tests',
                        'slug' => 'assign.tests',
                        'description' => 'Tests', // optional
                        'model' => 'App\Models\Test'
            ]);
        }

        //Permissions for Positions
        $viewRolePermissionCount = Permission::where('slug', 'view.positions')->count();
        if ($viewRolePermissionCount === 0) {
            $viewRolePermission = Permission::create([
                        'name' => 'View Positions',
                        'slug' => 'view.positions',
                        'description' => 'Positions', // optional
                        'model' => 'App\Models\Role'
            ]);
        }

        $createRolePermissionCount = Permission::where('slug', 'create.positions')->count();
        if ($createRolePermissionCount === 0) {
            $createRolePermission = Permission::create([
                        'name' => 'Create Positions',
                        'slug' => 'create.positions',
                        'description' => 'Positions', // optional
                        'model' => 'App\Models\Role'
            ]);
        }

        $editRolePermissionCount = Permission::where('slug', 'edit.positions')->count();
        if ($editRolePermissionCount === 0) {
            $editRolePermission = Permission::create([
                        'name' => 'Edit Positions',
                        'slug' => 'edit.positions',
                        'description' => 'Positions', // optional
                        'model' => 'App\Models\Role'
            ]);
        }

        $deleteRolePermissionCount = Permission::where('slug', 'delete.positions')->count();
        if ($deleteRolePermissionCount === 0) {
            $deleteRolePermission = Permission::create([
                        'name' => 'Delete Positions',
                        'slug' => 'delete.positions',
                        'description' => 'Positions', // optional
                        'model' => 'App\Models\Role'
            ]);
        }

        $assignRolePermissionCount = Permission::where('slug', 'assign.positions')->count();
        if ($assignRolePermissionCount === 0) {
            $assignRolePermission = Permission::create([
                        'name' => 'Assign Positions',
                        'slug' => 'assign.positions',
                        'description' => 'Positions', // optional
                        'model' => 'App\Models\Role'
            ]);
        }

        //Permissions for Tickets
        $viewTicketsPermissionCount = Permission::where('slug', 'view.tickets')->count();
        if ($viewTicketsPermissionCount === 0) {
            $viewTicketsPermission = Permission::create([
                        'name' => 'View Tickets',
                        'slug' => 'view.tickets',
                        'description' => 'Tickets', // optional
                        'model' => 'App\Models\Ticket'
            ]);
        }

        $createTicketsPermissionCount = Permission::where('slug', 'create.tickets')->count();
        if ($createTicketsPermissionCount === 0) {
            $createTicketsPermission = Permission::create([
                        'name' => 'Create Tickets',
                        'slug' => 'create.tickets',
                        'description' => 'Tickets', // optional
                        'model' => 'App\Models\Ticket'
            ]);
        }

        //Permissions for Company Links
        $deleteLinksPermissionCount = Permission::where('slug', 'delete.links')->count();
        if ($deleteLinksPermissionCount === 0) {
            $deleteLinksPermissionCount = Permission::create([
                        'name' => 'Delete Link',
                        'slug' => 'delete.links',
                        'description' => 'Links', // optional
                        'model' => 'App\Models\Link'
            ]);
        }

        $editLinksPermissionCount = Permission::where('slug', 'edit.links')->count();
        if ($editLinksPermissionCount === 0) {
            $editLinksPermissionCount = Permission::create([
                        'name' => 'Edit Links',
                        'slug' => 'edit.links',
                        'description' => 'Links', // optional
                        'model' => 'App\Models\Link'
            ]);
        }
        //Permissions for Applicants Upload Resume and Photo
        $editApplicantsPermissionCount = Permission::where('slug', 'edit.applicants')->count();
        if ($editApplicantsPermissionCount === 0) {
            $editApplicantsPermissionCount = Permission::create([
                        'name' => 'Upload Applicants Photo and Resume',
                        'slug' => 'edit.applicants',
                        'description' => 'Applicants', // optional
                        'model' => 'App\Models\Applicants'
            ]);
        }

    }

}
