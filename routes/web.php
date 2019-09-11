<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 *  you can see the list of all the routes with all details by typing,
 *  php artisan route:list on the commandline. also change your directory to 
 *  this project directory when doing so.
 */

/**
 * Dashboard Route(s)
 * 
 */
Route::get('/dashboard','DashboardController@index')->name('dashboard');
Route::post('/dashboard','DashboardController@getStaff')->name('dashboard.getstaff');
Route::post('/dashboard/postleave','DashboardController@postLeave')->name('dashboard.postleave');
Route::post('/dashboard/attendance','DashboardController@postAttendance')->name('dashboard.attendance');

/**
 * Attendance Route(s)
 * 
 */
Route::get('/attendance','AttendanceController@index')->name('attendance');
Route::post('/attendance/postattendance','AttendanceController@postAttendance')->name('attendance.postattendance');

/**
 * Overtime Route(s)
 * 
 */
Route::get('/overtime','OvertimeController@index')->name('overtime');
Route::post('/overtime/postovertime','OvertimeController@postOvertime');
Route::get('/overtime/myovertime','OvertimeController@myOvertime');
Route::post('/overtime/myovertime','OvertimeController@postMyOvertime');
Route::get('/overtime/verify','OvertimeController@verify');
Route::post('/overtime/postverify/{id}','OvertimeController@postVerify')->name('overtime.postverify');
;
Route::post('/overtime/rejectverify/{id}','OvertimeController@rejectVerify')->name('overtime.rejectverify');
;
Route::get('/overtime/approve','OvertimeController@approve');
Route::post('/overtime/postapprove/{id}','OvertimeController@postApprove')->name('overtime.postapprove');
;
Route::post('/overtime/rejectapprove/{id}','OvertimeController@rejectApprove')->name('overtime.rejectapprove');
Route::post('/overtime/cancel/{id}','OvertimeController@cancel')->name('overtime.cancel');
Route::get('/overtime/myovertime/show/{id}','OvertimeController@show')->name('overtime.show');
Route::get('/overtime/report_by_sum','OvertimeController@reportBySum');
Route::post('/overtime/report_by_sum','OvertimeController@searchBySum');
Route::get('/overtime/export','OvertimeController@indexExport');
Route::post('/overtime/export','OvertimeController@postExport');
Route::get('/overtime/report/detail','OvertimeController@detail')->name('overtime.detail');
Route::get('/overtime/report/export_detail','OvertimeController@expDetail')->name('overtime.expdetail');

/* Export to Excel-CSV-PDF */
Route::get('/overtime/export/xlsx', 'OvertimeController@exportExcel');
Route::get('/overtime/export/csv', 'OvertimeController@exportCsv');
Route::get('/overtime/export/pdf','OvertimeController@exportPdf');
Route::get('/overtime/report/xlsx', 'OvertimeController@reportExcel');


/**
 *  Departments Route(s)
 * 
 */
Route::resource('/departments','DepartmentsController');
Route::post('/departments/search','DepartmentsController@search')->name('departments.search');

/**
 *  Countries Route(s)
 */
Route::resource('/countries','CountriesController');
Route::post('/countries/search','CountriesController@search')->name('countries.search');
Route::resource('/nationalities','NationalitiesController');
Route::post('/nationalities/search','NationalitiesController@search')->name('nationalities.search');

/**
 *  Cities Route(s)
 */
Route::resource('/cities','CitiesController');
Route::post('/cities/search','CitiesController@search')->name('cities.search');
Route::resource('/reportingmanagers','ReportingManagersController');
Route::post('/reportingmanagers/search','ReportingManagersController@search')->name('reportingmanagers.search');

/**
 *  Salaries Route(s)
 */
Route::resource('/salaries','SalariesController');
Route::post('/salaries/search','SalariesController@search')->name('salaries.search');
Route::resource('/locations','LocationsController');
Route::post('/locations/search','LocationsController@search')->name('locations.search');

/**
 *  Divisions Route(s)
 */
Route::resource('/divisions','DivisionsController');
Route::post('/divisions/search','DivisionsController@search')->name('divisions.search');
Route::resource('/functionals','FunctionalsController');
Route::post('/functionals/search','FunctionalsController@search')->name('functionals.search');

/**
 *  States Route(s)
 */
Route::resource('/states','StatesController');
Route::post('/states/search','StatesController@search')->name('states.search');
Route::resource('/jobtitles','JobTitlesController');
Route::post('/jobtitles/search','JobTitlesController@search')->name('jobtitles.search');

/**
 *  States Route(s)
 */
Route::resource('/employees','EmployeesController');
Route::post('employees/search','EmployeesController@search')->name('employees.search');
Route::get('/employee_by_department','EmployeesController@department');
Route::post('employee_by_department','EmployeesController@searchByDept');
Route::get('/employees/show/{id}','EmployeesController@show');
Route::get('/employee_verifier_approver','EmployeesController@getVerApp');
Route::post('/employee_verifier_approver','EmployeesController@postVerApp');
Route::get('/employees/edit_approver/{id}','EmployeesController@editApprover')->name('employees.edit_approver');
Route::post('/employees/post_approver','EmployeesController@postApprover')->name('employees.post_approver');
Route::post('employee/filter_dept','EmployeesController@filterDept');
Route::post('employee/filter_funct','EmployeesController@filterFunct');

/**
 *  Admins Route(s)
 */
//Route::resource('/admins','AdminsController');
//Route::post('/admins','AdminsController@search')->name('admins.search');
//Route::post('/admins/create','AdminsController@store')->name('admins.store');

/**
 *  Users Route(s)
 */
Route::resource('/users','UsersController');
Route::post('/users','UsersController@search')->name('users.search');
Route::post('/users/create','UsersController@store')->name('users.store');

/**
 *  Holidays Route(s)
 */
Route::resource('/holidays','HolidaysController');
Route::post('/holidays','HolidaysController@search')->name('holidays.search');
Route::post('/holidays/create','HolidaysController@store')->name('holidays.store');

/**
 *  Leave Records Route(s)
 */
Route::prefix('leaves')->group(function () {	
	//resource get and post
	Route::resource('/leave_records','LeaveRecordsController');
	Route::post('/leave_records','LeaveRecordsController@search1')->name('leave_records.search1');	
	//by date get and post
	Route::get('/leave_by_date','LeaveRecordsController@leaveByDate');
	Route::post('/leave_by_date','LeaveRecordsController@searchByDate');
	//by id get and post
	Route::get('/leave_by_id','LeaveRecordsController@leaveById');
	Route::post('/leave_by_id','LeaveRecordsController@searchById');
	//by department get and post
	Route::get('/leave_by_department','LeaveRecordsController@leaveByDept');
	Route::post('/leave_by_department','LeaveRecordsController@searchByDept');
	//by department sum and groupby
	Route::get('/leave_by_sum','LeaveRecordsController@leaveBySum');
	Route::post('/leave_by_sum','LeaveRecordsController@searchBySum');
	//resource post - create
	Route::post('/leave_records/create','LeaveRecordsController@store')->name('leave_records.store');
	//all leave pending
	Route::get('/leave_pending','LeaveRecordsController@leavePending');
	Route::post('/leave_pending','LeaveRecordsController@searchPending');
	Route::get('/leave_by_id/detail','LeaveRecordsController@detail');
	//Export to Excel
	Route::get('/report/xlsx', 'LeaveRecordsController@reportExcel');
});

/**
 *  Leave Records Route(s)
 */
Route::prefix('my_reports')->group(function () {	
	//resource get and post
	Route::resource('/leave_reports','LeaveReportsController');
	Route::post('/leave_reports','LeaveReportsController@search1')->name('leave_reports.search1');	
	//by id get and post
	Route::get('/report_by_id','LeaveReportsController@leaveById');
	Route::post('/report_by_id','LeaveReportsController@searchById');
	Route::get('/report_by_id/detail','LeaveRecordsController@detail');
	//by department sum and groupby
	Route::get('/report_by_sum','LeaveReportsController@leaveBySum');
	Route::post('/report_by_sum','LeaveReportsController@searchBySum');
	//resource post - create
	Route::post('/leave_reports/create','LeaveReportsController@store')->name('leave_reports.store');
	//resource get and post
	Route::get('/report_pending','LeaveReportsController@leavePending');
	Route::post('/report_pending','LeaveReportsController@searchPending');
	//Export to Excel
	Route::get('/report/xlsx', 'LeaveRecordsController@reportExcel');
});

/**
 *  Leave in Leu Route(s)
 */
Route::prefix('inleus')->group(function () {	
	Route::resource('/in_leu_records','InLeuRecordsController');
	Route::get('/in_leu_by_department','InLeuRecordsController@department');
	Route::post('/in_leu_by_department/post_inleu','InLeuRecordsController@postInleu')->name('in_leu_by_department.post_inleu');
	Route::post('/in_leu_records/search1','InLeuRecordsController@search1')->name('in_leu_records.search1');
	Route::get('/in_leu_by_department/search2','InLeuRecordsController@search2')->name('in_leu_records.search2');
	Route::get('/in_leu_by_add','InLeuRecordsController@addDepartment');
	Route::post('/in_leu_by_add/search3','InLeuRecordsController@search3')->name('in_leu_records.search3');
	Route::post('/in_leu_records/create','InLeuRecordsController@store')->name('in_leu_records.store');

	Route::get('/in_leu_by_sum','InLeuRecordsController@indexBySum');
	Route::post('/in_leu_by_sum','InLeuRecordsController@searchBySum');
	Route::get('/report/detail','InLeuRecordsController@detail');
});

/**
 *  Leave Attendance Route(s)
 */
Route::prefix('attendances')->group(function () {	
	Route::resource('/attendance_problems','AttendanceProblemsController');
	Route::post('/attendance_problems','AttendanceProblemsController@postIndex');
	Route::get('/att_by_department','AttendanceProblemsController@department');
	Route::post('/att_by_department','AttendanceProblemsController@postDepartment');
});

/**
 *  My Leaves Route(s)
 */
Route::resource('/my_leaves','MyLeavesController');
Route::post('/my_leaves','MyLeavesController@search')->name('my_leaves.search');
Route::post('/my_leaves/approve/{id}','MyLeavesController@approve')->name('my_leaves.approve');
Route::post('/my_leaves/reject/{id}','MyLeavesController@reject')->name('my_leaves.reject');
Route::post('/my_leaves/cancel/{id}','MyLeavesController@cancel')->name('my_leaves.cancel');
Route::post('/my_leaves/create','MyLeavesController@store')->name('my_leaves.store');
// Attached PDF
Route::get('/pdf_attach/attach', 'MyLeavesController@attachPdf');
// Attached IMAGE
Route::get('/image_attach/attach', 'MyLeavesController@attachImage');

/**
 *  My Leaves Route(s)
 */
Route::resource('/my_attendances','MyAttendancesController');
Route::post('/my_attendances','MyAttendancesController@search')->name('my_attendances.search');
Route::post('/my_attendances/approve/{id}','MyAttendancesController@approve')->name('my_attendances.approve');
Route::post('/my_attendances/reject/{id}','MyAttendancesController@reject')->name('my_attendances.reject');
Route::post('/my_attendances/create','MyAttendancesController@store')->name('my_attendances.store');

/**
 *  My Leave Tasks Route(s)
 */
Route::resource('/my_leave_tasks','MyLeaveTasksController');
Route::post('/my_leave_tasks','MyLeaveTasksController@search')->name('my_leave_tasks.search');
Route::post('/my_leave_tasks/approve/{id}','MyLeaveTasksController@approve')->name('my_leave_tasks.approve');
Route::post('/my_leave_tasks/reject/{id}','MyLeaveTasksController@reject')->name('my_leave_tasks.reject');
Route::post('/my_leave_tasks/create','MyLeaveTasksController@store')->name('my_leave_tasks.store');

/**
 *  My Attendance Tasks Route(s)
 */
Route::resource('/my_att_tasks','MyAttTasksController');
Route::post('/my_att_tasks','MyAttTasksController@search')->name('my_att_tasks.search');
Route::post('/my_att_tasks/approve/{id}','MyAttTasksController@approve')->name('my_att_tasks.approve');
Route::post('/my_att_tasks/reject/{id}','MyAttTasksController@reject')->name('my_att_tasks.reject');
Route::post('/my_att_tasks/create','MyAttTasksController@store')->name('my_att_tasks.store');

/**
 *  Auth Route(s)
 */

//show the login view
Route::get('/','AuthController@index')->name('login')->middleware('guest');

//Authenticate a user
Route::post('/','AuthController@authenticate')->name('auth.authenticate');

//logout the user
Route::get('/logout','AuthController@logout')->name('auth.logout')->middleware('auth');

//show user details
//Route::get('/admin','AuthController@show')->name('auth.show')->middleware('auth');

//show user details
Route::get('/user','AuthController@show')->name('auth.show')->middleware('auth');

Route::get('/password/reset','ResetPassword\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email','ResetPassword\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}','ResetPassword\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset','ResetPassword\ResetPasswordController@reset');