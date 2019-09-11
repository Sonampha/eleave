<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceProblem;
use App\AttendanceStatus;
use App\ReportingManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Mail\AttTaskMail;
use App\Mail\AttRejectMail;
use Mail;
use DB;

class MyAttTasksController extends Controller
{
    /**
     *  Only authenticated attendance-records can access this controller
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         *  It works the same as employeescontroller
         *  please see the comments for explaination
         *  on what's going on here.
         */
        $username = Auth::user()->username;  
        $my_name = Auth::user()->full_name;
        $attendance_problems = DB::table('attendance_problems')
                ->join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->where('approver',$my_name)
                ->where('status','Pending')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->orderBy('att_date', 'desc')
                ->paginate(100);
        return view('my_att_task.index')->with('attendance_problems',$attendance_problems);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $att_statuses = AttendanceStatus::all();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        return view('my_att_task.create')->with(['att_statuses'=>$att_statuses,'reporting_managers'=>$reporting_managers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance_problem = new AttendanceProblem();
        $this->validateRequest($request,NULL);
        $this->setAttendanceProblem($request ,$attendance_problem);
        return redirect('/my_att_tasks')->with('info','New Attendance Record has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance_problem = DB::table('attendance_problems')
                ->where('attendance_problems.id',$id)
                ->join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->first();
        return view('my_att_task.show')->with('attendance_problem',$attendance_problem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance_problem = AttendanceProblem::find($id);
        $att_statuses = AttendanceStatus::all();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        return view('my_att_task.edit')
            ->with(['attendance_problem'=>$attendance_problem,
                'att_statuses'=>$att_statuses,
                'reporting_managers'=>$reporting_managers
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request,$id);        
        $attendance_problem = AttendanceProblem::find($id);
        $this->setAttendanceProblem($request, $attendance_problem);

        return redirect('/my_att_tasks')->with('info','Selected Attendance Record has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         *  Check if the attendance_problem is not the
         *  current authenticated attendance_problem
         */
        
        $attendance_problem = AttendanceProblem::find($id);
        $attendance_problem->delete();
        return redirect('/my_att_tasks')->with('info','Selected Attendance Record has been Deleted!');
    }

    /**
     * Approve the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $attendance_problem = AttendanceProblem::find($id);
        $staff_id = $attendance_problem->staff_id;
        $user = DB::table('users')->where('username',$staff_id)->first();

        $data = [
                'staff_name' => $user->full_name,
                'man_name' => Auth::user()->full_name,
                'staff_email' => $user->email,
                'man_email' => Auth::user()->email,
            ];
        Mail::send(new AttTaskMail($data));
        /**
         *  Check if the attendance_problem is not the
         *  current authenticated attendance_problem
         */
        $date_current = Carbon::now()->toDateTimeString();
        
        $attendance_problem->status = $request->input('status');
        $attendance_problem->status_date = $date_current;
        $attendance_problem->save();
        return redirect('/my_att_tasks')->with('info','Selected Attendance Request has been Approved!');
    }

    /**
     * Reject the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $id)
    {
        $attendance_problem = AttendanceProblem::find($id);
        $staff_id = $attendance_problem->staff_id;
        $user = DB::table('users')->where('username',$staff_id)->first();

        $data = [
                'staff_name' => $user->full_name,
                'man_name' => Auth::user()->full_name,
                'staff_email' => $user->email,
                'man_email' => Auth::user()->email,
            ];
        Mail::send(new AttRejectMail($data));
        /**
         *  Check if the attendance_problem is not the
         *  current authenticated attendance_problem
         */
        $date_current = Carbon::now()->toDateTimeString();

        $attendance_problem->status = $request->input('status');
        $attendance_problem->status_date = $date_current;
        $attendance_problem->save();
        return redirect('/my_att_tasks')->with('info','Selected Attendance Request has been Rejected!');
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        $my_name = Auth::user()->full_name;

        $attendance_problems = DB::table('attendance_problems')
                ->join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->where('att_date','>=',$date_from)
                ->where('att_date','<=',$date_to)
                ->where('approver',$my_name)
                ->orderBy('att_date', 'desc')->paginate(100);

        return view('my_att_task.index')->with([ 'attendance_problems' => $attendance_problems ,'search' => true ]);
    }

    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
            'staff_id'     =>  'required|min:3|max:50',
            'staff_name'   =>  'required|min:3|max:50',
            'leave_type'   =>  'required',
            'day_off'      =>  'required|min:1',
            'date_from'    =>  'required',
            'date_to'      =>  'required',
            'unit'         =>  'required|min:2|max:10',
            'reason'       =>  'required|max:190',
            'reporting_manager'    =>  'required',
            'status'       =>  'required'
        ]);
    }

    /**
     * Add or update an attendance_problem
     */
    private function setAttendanceProblem(Request $request , AttendanceProblem $attendance_problem){
        $attendance_problem->staff_id = $request->input('staff_id');
        $attendance_problem->staff_name = $request->input('staff_name');
        $attendance_problem->leave_type = $request->input('leave_type');
        $attendance_problem->day_off = $request->input('day_off');
        //Format Date then insert it to the database
        $attendance_problem->date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $attendance_problem->date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        $attendance_problem->unit = $request->input('unit');
        $attendance_problem->reason = $request->input('reason');
        $attendance_problem->approver = $request->input('reporting_manager');
        $attendance_problem->status = $request->input('status');
        $attendance_problem->status_date = NULL;

        $attendance_problem->save();
    }  
}
