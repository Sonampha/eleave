<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendanceProblem;
use App\AttendanceStatus;
use App\ReportingManager;
use App\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;

class AttendanceProblemsController extends Controller
{
    /**
     *  Only authenticated attendance_problems can access this controller
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
        $attendance_problems = AttendanceProblem::join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->orderBy('att_date', 'desc')
                ->Paginate(30);

        return view('attendance_problem.index')->with('attendance_problems',$attendance_problems);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postIndex(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        $attendance_problems = AttendanceProblem::join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->where('att_date','>=',$date_from)->where('att_date','<=',$date_to)
                ->orderBy('att_date', 'desc')->get();
        return view('attendance_problem.post_index')->with([ 'attendance_problems' => $attendance_problems ,
            'date_from' => $date_from,
            'date_to' => $date_to]);
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
        return view('attendance_problem.create')->with(['att_statuses'=>$att_statuses,'reporting_managers'=>$reporting_managers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendance_problems = new AttendanceProblem();
        $this->validateRequest($request,NULL);
        $this->setAttendanceProblem($request ,$attendance_problems);
        return redirect('/attendances/attendance_problems')->with('info','New Attendance Record has been Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance_problem = AttendanceProblem::where('attendance_problems.id',$id)
                ->join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->first();
        return view('attendance_problem.show')->with('attendance_problem',$attendance_problem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance_problem = AttendanceProblem::join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
                ->select('attendance_problems.*', 'employees.staff_name')
                ->where('attendance_problems.id',$id)
                ->first();
        $att_statuses = AttendanceStatus::all();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        return view('attendance_problem.edit')
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
        $this->validate($request,[
            'staff_id'     =>  'required|min:3|max:50',
            'att_status'   =>  'required',
            'att_date'    =>  'required',
            'att_reason'       =>  'required|max:190',
            'reporting_manager'    =>  'required',
            'status'       =>  'required'
        ]);   
        $attendance_problem = AttendanceProblem::find($id);
        $this->setAttendanceProblem($request, $attendance_problem);

        return redirect('/attendances/attendance_problems/'.$id)->with('info','Selected Attendance Record has been Updated');
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
         *  Check if the attendance_problems is not the
         *  current authenticated attendance_problems
         */
        
        $attendance_problem = AttendanceProblem::find($id);
        $attendance_problem->delete();
        return redirect('/attendances/attendance_problems')->with('info','Selected Attendance Record has been Deleted!');
    }


    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
            'staff_id'     =>  'required|min:3|max:50',
            'staff_name'   =>  'required|min:3|max:50',
            'att_status'   =>  'required',
            'att_date'    =>  'required',
            'att_reason'       =>  'required|max:190',
            'reporting_manager'    =>  'required',
            'status'       =>  'required'
        ]);
    }

    /**
     * Add or update an attendance_problems
     */
    private function setAttendanceProblem(Request $request , AttendanceProblem $attendance_problem){
        $attendance_problem->staff_id = $request->input('staff_id');
        $attendance_problem->att_status = $request->input('att_status');
        //Format Date then insert it to the database
        $attendance_problem->att_date   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('att_date'))));
        $attendance_problem->att_reason = $request->input('att_reason');
        $attendance_problem->approver = $request->input('reporting_manager');
        $attendance_problem->status = $request->input('status');
        //$attendance_problem->request_date = Carbon::now()->toDateTimeString();
        //$attendance_problem->status_date = Carbon::now()->toDateTimeString();

        $attendance_problem->save();
    } 

    public function department()
    {      
        $departments = Department::all();
        $att_statuses = AttendanceStatus::all();
        $attendance_problems = AttendanceProblem::join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('attendance_problems.*', 'employees.staff_name','departments.dept_name')
            ->orderBy('att_date', 'desc')
            ->paginate(15);
        return view('attendance_problem.department')->with(['attendance_problems'=>$attendance_problems,
            'att_statuses'=>$att_statuses,
            'departments'=>$departments]);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postDepartment(Request $request){
        $departments = Department::all();
        $att_statuses = AttendanceStatus::all();

        $this->validate($request,[
            'department' => 'required',
            'att_status' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $dep_id = $request->input('department');
        $att_status = $request->input('att_status');
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $attendance_problems = AttendanceProblem::join('employees', 'attendance_problems.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('attendance_problems.*', 'employees.staff_name','departments.dept_name')
            ->where('att_status',$att_status)
            ->where('dept_id',$dep_id)
            ->where('att_date','>=',$date_from)
            ->where('att_date','<=',$date_to)
            ->orderBy('att_date', 'desc')
            ->get();

        return view('attendance_problem.post_department')->with([ 'attendance_problems' => $attendance_problems ,
            'dep_id'=>$dep_id,
            'att_stat'=>$att_status,
            'att_statuses'=>$att_statuses,
            'departments'=>$departments,
            'date_from' => $date_from,
            'date_to' => $date_to]);
    }

}
