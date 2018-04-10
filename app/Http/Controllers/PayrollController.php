<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \View;
use \DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskChecklist;
use App\Models\Timer;
use App\Models\Rate;
use App\Models\Payroll;
use App\Models\PayrollColumn;
use App\Models\PayPeriod;
use App\Models\UserPayPeriod;
use App\Models\UserPayrollColumn;

class PayrollController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $assets = [];

        $c = DB::table('companies')
                ->select('id', 'name')
                ->get();
        $company = array_pluck($c, 'name', 'id');

        return View::make('payroll.default', [
                    'assets' => $assets,
                    'company' => $company
        ]);
    }

    public function payrollJson() {
        header("Content-type: application/json");

        $result = array();
        $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : '';
        if ($company_id) {
            $result = DB::table('employees')
                    ->where('company_id', '=', $company_id)
                    ->get();

            if (count($result) > 0) {
                foreach ($result as $v) {
                    $v->payroll = DB::table('task_timer')
                            ->select(DB::raw(
                                            'fp_task.task_title,
                            CONCAT(
                                DATE_FORMAT(fp_task_timer.start_time, "%a %d"),
                                ", ",
                                DATE_FORMAT(fp_task_timer.start_time, "%h:%i %p"),
                                " - ",
                                DATE_FORMAT(fp_task_timer.end_time, "%h:%i %p")
                            ) as time,
                            CONCAT(
                                ROUND(ROUND(TIMESTAMPDIFF(SECOND, fp_task_timer.start_time, fp_task_timer.end_time)/3600, 2) * fp_user_payroll_setting.hourly_rate, 2),
                                " ", fp_user_payroll_setting.currency
                            ) as amount'
                            ))
                            ->leftJoin('task', 'task.task_id', '=', 'task_timer.task_id')
                            ->leftJoin('user_payroll_setting', 'user_payroll_setting.user_id', '=', 'task_timer.user_id')
                            ->where('task_timer.user_id', '=', $v->user_id)
                            ->get();
                }
            }
        }

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $employees = Profile::with('user', 'rate')->where('company_id', $id)->get();

        $employee_ids = [];
        $project_ids = [];
        foreach ($employees as $employee) {
            array_push($employee_ids, $employee->user->user_id);
        }

        //Get the task checklists for today(Filter will start at today's day)
        $date_today = date('Y-m-d');

        $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                        $task_checklist_query->with(['task' => function($task_query) {
                                $task_query->with('project')->get();
                            }])->get();
                    }])->whereIn('user_id', $employee_ids)
                        ->whereBetween('created_at', [$date_today . ' 00:00:00', $date_today . ' 23:59:59'])
                        ->whereNotIn('total_time', ['NULL', '00:00:00'])
                        ->get();


                foreach ($task_checklists as $task_checklist) {
                    array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                }

                $projects = Project::whereIn('project_id', $project_ids)->where('company_id', $id)->get();

                $total_time_per_project = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours, DATE_FORMAT(created_at,'%Y-%m-%d') as day , user_id, project_id"))->whereBetween('created_at', [$date_today . ' 00:00:00', $date_today . ' 23:59:59'])->groupBy('project_id')->groupBy('user_id')->get();

                $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereBetween('created_at', [$date_today . ' 00:00:00', $date_today . ' 23:59:59'])->groupBy('user_id')->get();

                $assets = ['select', 'payroll', 'assets'];

                return view('payroll.show', [
                    'assets' => $assets,
                    'employees' => $employees,
                    'task_checklists' => $task_checklists,
                    'projects' => $projects,
                    'total_time_per_project' => $total_time_per_project,
                    'total_time' => $total_time,
                    'company_id' => $id
                ]);
            }

            /**
             * Show the form for editing the specified resource.
             *
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function edit($id) {
                //
            }

            /**
             * Update the specified resource in storage.
             *
             * @param  \Illuminate\Http\Request  $request
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function update(Request $request, $id) {
                //
            }

            /**
             * Remove the specified resource from storage.
             *
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function destroy($id) {
                //
            }

            public function filter(Request $request, $company_id, $filter, $date) {

                $employees = Profile::with('user', 'rate')->where('company_id', $company_id)->get();

                $employee_ids = [];
                $project_ids = [];
                foreach ($employees as $employee) {
                    array_push($employee_ids, $employee->user->user_id);
                }

                if ($filter === 'day') {

                    $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                                    $task_checklist_query->with(['task' => function($task_query) {
                                            $task_query->with('project')->get();
                                        }])->get();
                                }])->whereIn('user_id', $employee_ids)->whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->get();


                            foreach ($task_checklists as $task_checklist) {
                                array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                            }

                            $projects = Project::whereIn('project_id', $project_ids)->where('company_id', $company_id)->get();

                            $total_time_per_project = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours, DATE_FORMAT(created_at,'%Y-%m-%d') as day , user_id, project_id"))->whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->groupBy('project_id')->groupBy('user_id')->get();

                            $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereBetween('created_at', [$date . ' 00:00:00', $date . ' 23:59:59'])->groupBy('user_id')->get();

                            return view('payroll.filter', [
                                'employees' => $employees,
                                'task_checklists' => $task_checklists,
                                'projects' => $projects,
                                'total_time_per_project' => $total_time_per_project,
                                'total_time' => $total_time,
                                'company_id' => $company_id
                            ]);
                        } elseif ($filter === 'week') {

                            $date_array = explode("-", $date);
                            $month = $date_array[1];
                            $year = $date_array[0];
                            $week = $date_array[3];

                            $monday = date("Y-m-d", strtotime($year . "-W" . $week . "-1"));
                            $sunday = date("Y-m-d", strtotime($year . "-W" . $week . "-7"));

                            $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                                            $task_checklist_query->with(['task' => function($task_query) {
                                                    $task_query->with('project')->get();
                                                }])->get();
                                        }])->whereIn('user_id', $employee_ids)->whereBetween('created_at', [$monday . ' 00:00:00', $sunday . ' 23:59:59'])->get();


                                    foreach ($task_checklists as $task_checklist) {
                                        array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                                    }

                                    $projects = Project::whereIn('project_id', $project_ids)->where('company_id', $company_id)->get();

                                    $total_time_per_project = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours, DATE_FORMAT(created_at,'%Y-%m-%d') as day , user_id, project_id"))->whereBetween('created_at', [$monday . ' 00:00:00', $sunday . ' 23:59:59'])->groupBy('project_id')->groupBy('user_id')->get();

                                    $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereBetween('created_at', [$monday . ' 00:00:00', $sunday . ' 23:59:59'])->groupBy('user_id')->get();

                                    return view('payroll.filter', [
                                        'employees' => $employees,
                                        'task_checklists' => $task_checklists,
                                        'projects' => $projects,
                                        'total_time_per_project' => $total_time_per_project,
                                        'total_time' => $total_time,
                                        'company_id' => $company_id
                                    ]);
                                } else if ($filter === 'month') {

                                    $date_array = explode("-", $date);
                                    $month = $date_array[0];
                                    $year = $date_array[2];

                                    $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                                                    $task_checklist_query->with(['task' => function($task_query) {
                                                            $task_query->with('project')->get();
                                                        }])->get();
                                                }])->whereIn('user_id', $employee_ids)->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get();


                                            foreach ($task_checklists as $task_checklist) {
                                                array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                                            }

                                            $projects = Project::whereIn('project_id', $project_ids)->where('company_id', $company_id)->get();

                                            $total_time_per_project = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours, DATE_FORMAT(created_at,'%Y-%m-%d') as day , user_id, project_id"))->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->groupBy('project_id')->groupBy('user_id')->get();

                                            $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->groupBy('user_id')->get();

                                            return view('payroll.filter', [
                                                'employees' => $employees,
                                                'task_checklists' => $task_checklists,
                                                'projects' => $projects,
                                                'total_time_per_project' => $total_time_per_project,
                                                'total_time' => $total_time,
                                                'company_id' => $company_id
                                            ]);
                                        } else if ($filter === 'year') {

                                            $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                                                            $task_checklist_query->with(['task' => function($task_query) {
                                                                    $task_query->with('project')->get();
                                                                }])->get();
                                                        }])->whereIn('user_id', $employee_ids)->whereYear('created_at', '=', $date)->get();


                                                    foreach ($task_checklists as $task_checklist) {
                                                        array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                                                    }

                                                    $projects = Project::whereIn('project_id', $project_ids)->where('company_id', $company_id)->get();

                                                    $total_time_per_project = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours, DATE_FORMAT(created_at,'%Y-%m-%d') as day , user_id, project_id"))->whereYear('created_at', '=', $date)->groupBy('project_id')->groupBy('user_id')->get();

                                                    $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereYear('created_at', '=', $date)->groupBy('user_id')->get();

                                                    return view('payroll.filter', [
                                                        'employees' => $employees,
                                                        'task_checklists' => $task_checklists,
                                                        'projects' => $projects,
                                                        'total_time_per_project' => $total_time_per_project,
                                                        'total_time' => $total_time,
                                                        'company_id' => $company_id
                                                    ]);
                                                }
                                            }

                                            public function showPaymentHistory($id) {

                                                $employees = Profile::with(['user', 'rate' => function($rate_query) {
                                                                $rate_query->with(['pay_period', 'user_pay_period' => function($payday_query) {
                                                                        //$payday_query->with('payroll')->get();
                                                                    }])->get();
                                                            }])->where('company_id', $id)->get();

                                                        $employee_ids = [];
                                                        $project_ids = [];
                                                        foreach ($employees as $employee) {
                                                            array_push($employee_ids, $employee->user->user_id);
                                                        }

                                                        //Get the task checklists for today(Filter will start at today's day)
                                                        $month = date('m');

                                                        $task_checklists = Timer::with(['task_checklist' => function($task_checklist_query) {
                                                                        $task_checklist_query->with(['task' => function($task_query) {
                                                                                $task_query->with('project')->get();
                                                                            }])->get();
                                                                    }])->whereIn('user_id', $employee_ids)
                                                                        //->whereBetween('created_at', [$date_today . ' 00:00:00', $date_today . ' 23:59:59'])
                                                                        ->whereMonth('created_at', '=', $month)
                                                                        ->whereNotIn('total_time', ['NULL', '00:00:00'])
                                                                        ->get();


                                                                foreach ($task_checklists as $task_checklist) {
                                                                    array_push($project_ids, $task_checklist->task_checklist->task->project->project_id);
                                                                }

                                                                $additions = PayrollColumn::where('column_type', 'additions')->get();
                                                                $deductions = PayrollColumn::where('column_type', 'deductions')->get();

                                                                $total_time = Timer::select(DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_time ) ) ) AS timeSum, (SUM(TIME_TO_SEC( total_time )) / 3600) as hours , user_id"))->whereMonth('created_at', '=', $month)->groupBy('user_id')->get();
                                                                
                                                                $payroll_months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                                                                
                                                                $assets = ['select', 'payroll', 'assets'];

                                                                return view('payroll.paymenthistory', [
                                                                    'assets' => $assets,
                                                                    'employees' => $employees,
                                                                    'task_checklists' => $task_checklists,
                                                                    'additions' => $additions,
                                                                    'deductions' => $deductions,
                                                                    'payroll_months' => $payroll_months,
                                                                    'total_time' => $total_time,
                                                                    'company_id' => $id
                                                                ]);
                                                            }

                                                            public function showPayrollSettings($id) {

                                                                $payroll_columns = PayrollColumn::all();

                                                                $pay_periods = PayPeriod::all();

                                                                return view('payroll.payrollsettings', [
                                                                    'payroll_columns' => $payroll_columns,
                                                                    'pay_periods' => $pay_periods
                                                                ]);
                                                            }

                                                            /* For Global Payroll Columns */

                                                            public function addPayrollColumnForm() {
                                                                return view('forms.addPayrollColumnForm');
                                                            }

                                                            public function editPayrollColumnForm($id) {

                                                                $payroll_column = PayrollColumn::where('id', $id)->first();

                                                                return view('forms.editPayrollColumnForm', [
                                                                    'payroll_column' => $payroll_column
                                                                ]);
                                                            }

                                                            public function addPayrollColumn(Request $request) {

                                                                $column_name = $request->input('column_name');
                                                                $column_type = $request->input('column_type');
                                                                $default_value = $request->input('default_value');

                                                                $add_column = new PayrollColumn([
                                                                    'column_name' => $column_name,
                                                                    'column_type' => $column_type,
                                                                    'default_value' => $default_value
                                                                ]);
                                                                $add_column->save();

                                                                $payroll_columns = PayrollColumn::all();

                                                                return view('payroll.payrollColumns', [
                                                                    'payroll_columns' => $payroll_columns
                                                                ]);
                                                            }

                                                            public function editPayrollColumn(Request $request) {

                                                                $column_id = $request->input('column_id');

                                                                $column_name = $request->input('column_name');
                                                                $column_type = $request->input('column_type');
                                                                $default_value = $request->input('default_value');

                                                                $edit_column = PayrollColumn::where('id', $column_id)->update([
                                                                    'column_name' => $column_name,
                                                                    'column_type' => $column_type,
                                                                    'default_value' => $default_value
                                                                ]);

                                                                $payroll_columns = PayrollColumn::all();

                                                                return view('payroll.payrollColumns', [
                                                                    'payroll_columns' => $payroll_columns
                                                                ]);
                                                            }

                                                            public function deletePayrollColumn(Request $request) {

                                                                $column_id = $request->input('column_id');

                                                                $delete_column = PayrollColumn::where('id', $column_id)->delete();

                                                                $payroll_columns = PayrollColumn::all();

                                                                return view('payroll.payrollColumns', [
                                                                    'payroll_columns' => $payroll_columns
                                                                ]);
                                                            }

                                                            /* For Per User Payroll Columns */

                                                            public function addUserPayrollColumn(Request $request) {
                                                                //This overrides the global setting for a payroll column
                                                                //for that particular user

                                                                $profile_id = $request->input('profile_id');
                                                                $payroll_column_id = $request->input('column_id');
                                                                $value = $request->input('value');

                                                                $user_payroll_column = new UserPayrollColumn([
                                                                    'profile_id' => $profile_id,
                                                                    'payroll_column_id' => $payroll_column_id,
                                                                    'value' => $value
                                                                ]);
                                                                $user_payroll_column->save();

                                                                return "true";
                                                            }

                                                            public function editUserPayrollColumn(Request $request) {
                                                                //This overrides the global setting for a payroll column
                                                                //for that particular user
                                                            }

                                                            public function editPaymentStatus(Request $request) {
                                                                
                                                                $profile_id = $request->input('profile_id');
                                                                $status = $request->input('status');
                                                                
                                                                $user_pay_period_id = UserPayPeriod::where('profile_id', $profile_id)->pluck('id');
                                                                
                                                                $payroll = Payroll::where('user_pay_period_id', $user_pay_period_id)->update([
                                                                    'status' => $status
                                                                ]);
                                                                
                                                                return "true";
                                                            }

                                                        }
                                                        