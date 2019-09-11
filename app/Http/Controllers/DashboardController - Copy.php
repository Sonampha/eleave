<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Department;
use App\Division;
use App\Country;
use App\City;
use App\State;
use App\Salary;
//use App\Admin;
use App\User;
use Carbon\Carbon;
use App\LeaveType;
use App\ReportingManager;
use App\Nationality;
use App\LeaveRecord;
use App\InLeu;
use App\AttendanceStatus;
use App\AttendanceProblem;
use Auth;
use DB;
use App\Mail\LeaveUserMail;
use App\Mail\AttUserMail;
use Mail;

class DashboardController extends Controller
{
    /**
     *  Only authenticated users can access this controller
     */
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Show Dashboard View
     *
     * @return View
     */
    public function index(){
        $t_users = User::all()->count();
        $t_employees = Employee::all()->count();
        $t_departments = Department::all()->count();
        $leave_types = LeaveType::all();
        $att_statuses = AttendanceStatus::all();
        $current_date = Carbon::now()->toDateTimeString();        

        return view('dashboard.index')
            ->with([
                't_employees'     =>  $t_employees,
                't_departments'   =>  $t_departments,
                't_users'        =>  $t_users,
                'leave_types'  =>  $leave_types,
                'att_statuses'  =>  $att_statuses,
                'current_date'    =>  $current_date
            ]);
    }

   public function getStaff(Request $request) {
        $staff_id = $request->staff_id;
        $leave_type = $request->leave_type;        

        $sum_token = LeaveRecord::where('staff_id', $staff_id)
                   ->where('leave_type', $leave_type)
                   ->where('status','!=','Rejected')
                   ->where('status','!=','Cancelled')
                   ->sum('day_off');  

        $sum_inleu = InLeu::where('staff_id', $staff_id)->sum('inleu_day');       

        $employees = Employee::where('staff_id', $staff_id)->first();
        $work_day = $employees->work_day;
        $manager_name = $employees->empReportingManager->manager_name;
        $ann_leave = $employees->ann_leave;
        $sick_leave = $employees->sick_leave;
        $mat_leave = $employees->mat_leave;
        $hop_leave = $employees->hop_leave;
        $unp_leave = $employees->unp_leave;
        $spec_leave = $employees->spec_leave;
        $carry_leave = $employees->carry_leave; 
              
      return response()->json([        
        'work_day'=>$work_day,
        'manager_name'=>$manager_name,
        'ann_leave'=>$ann_leave,
        'sick_leave'=>$sick_leave,
        'mat_leave'=>$mat_leave,
        'hop_leave'=>$hop_leave,
        'unp_leave'=>$unp_leave,
        'spec_leave'=>$spec_leave,
        'carry_leave'=>$carry_leave,
        'in_leu'=>$sum_inleu,
        'sum_token'=>$sum_token,
        ]);
   }

   public function postLeave(Request $request){
        $staff_id = Auth::user()->username;
        $employee = DB::table('employees')
                ->join('reporting_managers', 'employees.reporting_manager_id', '=', 'reporting_managers.id')
                ->where('employees.staff_id',$staff_id)
                ->select('employees.id','employees.staff_id','employees.staff_name', 'reporting_managers.manager_name', 'reporting_managers.email','reporting_managers.cc_email','reporting_managers.dd_email','reporting_managers.ee_email')
                ->first();

        $data = [
                'my_name' => $employee->staff_name,
                'man_name' => $employee->manager_name,
                'my_email' => Auth::user()->email,
                'man_email' => $employee->email,
				'cc_email' => $employee->cc_email,
				'dd_email' => $employee->dd_email,
				'ee_email' => $employee->ee_email,
                'leave_type' => $request->leave_type,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'day_off' => $request->day_off,
                'unit' => $request->unit,
            ];

        /* Get Data from Ajax and Form */       
        if($request->date_from == '' OR $request->date_to == '' OR $request->reason == ''){  
            return response()->json(['info'=>'Sorry, leave form cannot be empty!']);
        }

        /* Check if date already exist */
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->date_from)));
        $date_exist = LeaveRecord::where('staff_id',$staff_id)->where('date_from',$date_from)->where('status','Pending')->orWhere('staff_id',$staff_id)->where('date_from',$date_from)->where('status','Approved')->get();

        if(count($date_exist) > 0){
            return response()->json(['info'=>'Sorry, you cannot apply twice with the same date.']);
        }

        if($request->day_off < 0){
            return response()->json(['info'=>'Sorry, date range cannot be negative!']);
        }

        if($request->new_balance < 0){
            return response()->json(['info'=>'Sorry, not enough leave balance!']);
        }        

        $staff_name = $employee->staff_name;
        $manager_name = $employee->manager_name;
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->date_from)));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->date_to)));

        /* Save Data to New Leave Record*/

        $leave_record = new LeaveRecord();
        $leave_record->staff_id = $staff_id;
        $leave_record->staff_name = $staff_name;
        $leave_record->leave_type = $request->leave_type;        
        $leave_record->date_from   = $date_from;
        $leave_record->date_to   = $date_to;
        $leave_record->day_off = $request->day_off;
        $leave_record->unit = $request->unit;
        $leave_record->reason = $request->reason;
        $leave_record->approver = $manager_name;
        $leave_record->status = 'Pending';
        $leave_record->request_date = Carbon::now()->toDateTimeString();
        $leave_record->status_date = NULL;        


        if($leave_record->save()){
            Mail::send(new LeaveUserMail($data));
            return response()->json(['msg'=>'Your leave request has been created successfully.']);            
        }else{
            return response()->json('info','Failed! to create leave request.');
        }       
   }

   public function postAttendance(Request $request){

        /* Get Data from Ajax and Form */
        $staff_id = Auth::user()->username;
        $employee = DB::table('employees')
                ->join('reporting_managers', 'employees.reporting_manager_id', '=', 'reporting_managers.id')
                ->where('employees.staff_id',$staff_id)
                ->select('employees.id','employees.staff_id','employees.staff_name', 'reporting_managers.manager_name', 'reporting_managers.email', 'reporting_managers.cc_email')
                ->first();

        $data = [               
                'my_name' => $employee->staff_name,
                'man_name' => $employee->manager_name,
                'my_email' => Auth::user()->email,
                'man_email' => $employee->email,
				'cc_email' => $employee->cc_email,
                'att_status' => $request->att_status,
                'att_date' => $request->att_date,
            ];

        $att_date   = date('Y-m-d', strtotime(str_replace('-', '/', $request->att_date)));

        if($att_date == '1970-01-01' || $att_date == ''){             
            return response()->json(['info'=>'Sorry, date cannot be empty!']);
        }

        if($request->att_reason == ''){
            return response()->json(['info'=>'Sorry, please give us your reason.']);
        }

        /* Save Data to New Leave Record*/

        $att_problems = new AttendanceProblem();
        $att_problems->staff_id = $staff_id;
        $att_problems->att_date   = $att_date;
        $att_problems->att_status   = $request->att_status;   
        $att_problems->att_reason = $request->att_reason;
        $att_problems->approver = $employee->manager_name;
        $att_problems->status = 'Pending';
        $att_problems->request_date = Carbon::now()->toDateTimeString();
        $att_problems->status_date = NULL;

        if($att_problems->save()){ 
            Mail::send(new AttUserMail($data));           
            return response()->json(['msg'=>'Your attendance request has been created successfully.']);
        }else{
            return response()->json('info','Failed! to create attendance request.');
        }       
   }

}
