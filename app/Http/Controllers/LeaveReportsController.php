<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveRecord;
use App\LeaveType;
use App\Employee;
use App\ReportingManager;
use App\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class LeaveReportsController extends Controller
{
    /**
     *  Only authenticated leave-records can access this controller
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
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('status','Approved')
            ->where('employees.dept_id',$dept_id)
            ->orderBy('date_from', 'desc')
            ->Paginate(20);
        return view('leave_report.index')->with('leave_records',$leave_records);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search1(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;
        
        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('status','Approved')
            ->where('employees.dept_id',$dept_id)
            ->where('date_from','>=',$date_from)
            ->where('date_to','<=',$date_to)
            ->orderBy('date_from', 'desc')
            ->get();
        return view('leave_report.search_for_edit')->with(['leave_records' => $leave_records,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
    }

    public function leaveByDate()
    {
        /**
         *  It works the same as employeescontroller
         *  please see the comments for explaination
         *  on what's going on here.
         */        
        $username = Auth::user()->username;  
        $my_name = Auth::user()->full_name;
        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('status','Approved')
            ->where('approver',$my_name)
            ->orderBy('date_from', 'desc')
            ->get();
        return view('leave_report.index_by_date')->with('leave_records',$leave_records);
    }

    public function leaveById()
    {
        /**
         *  It works the same as employeescontroller
         *  please see the comments for explaination
         *  on what's going on here.
         */        
        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('status','Approved')
            ->where('employees.dept_id',$dept_id)
            ->orderBy('date_from', 'desc')
            ->Paginate(20);
        return view('leave_report.index_by_id')->with('leave_records',$leave_records);
    }

    public function searchById(Request $request){
        $this->validate($request,[
            'staff_id' => 'required',
        ]);
        $staff_id   = $request->input('staff_id');

        $leave_records = LeaveRecord::where('staff_id',$staff_id)
        ->where('status','Approved')
        ->orderBy('date_from', 'desc')
        ->get();
        return view('leave_report.search_by_id')->with(['leave_records' => $leave_records,'staff_id' => $staff_id ]);
    }

    public function index2()
    {
        return view('leave_report.search_by_date');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_types = LeaveType::all();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        return view('leave_report.create')->with(['leave_types'=>$leave_types,'reporting_managers'=>$reporting_managers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leave_record = new LeaveRecord();
        $this->validateRequest($request,NULL);
        $this->setLeaveRecord($request ,$leave_record);
        return redirect('/my_reports/leave_reports')->with('info','New Leave Record has been Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave_record = LeaveRecord::find($id);
        return view('leave_report.show')->with('leave_record',$leave_record);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave_record = LeaveRecord::find($id);
        $leave_types = LeaveType::all();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        return view('leave_report.edit')
            ->with(['leave_record'=>$leave_record,
                'leave_types'=>$leave_types,
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
        $leave_record = LeaveRecord::find($id);
        $this->setLeaveRecord($request, $leave_record);

        return redirect('/my_reports/leave_reports')->with('info','Selected Leave Record has been Updated');
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
         *  Check if the leave_record is not the
         *  current authenticated leave_record
         */
        
        $leave_record = LeaveRecord::find($id);
        $leave_record->delete();
        return redirect('/my_reports/leave_reports')->with('info','Selected Leave Record has been Deleted!');
    }

    public function searchByDate(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        $leave_records = LeaveRecord::where('date_from','>=',$date_from)->where('date_to','<=',$date_to)->where('status','Approved')->orderBy('date_from', 'desc')->get();
        return view('leave_report.search_by_date')->with(['leave_records' => $leave_records,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
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
     * Add or update an leave_record
     */
    private function setLeaveRecord(Request $request , LeaveRecord $leave_record){
        $leave_record->staff_id = $request->input('staff_id');
        $leave_record->staff_name = $request->input('staff_name');
        $leave_record->leave_type = $request->input('leave_type');
        $leave_record->day_off = $request->input('day_off');
        //Format Date then insert it to the database
        $leave_record->date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $leave_record->date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        $leave_record->unit = $request->input('unit');
        $leave_record->reason = $request->input('reason');
        $leave_record->approver = $request->input('reporting_manager');
        $leave_record->status = $request->input('status');
        $leave_record->request_date = Carbon::now()->toDateTimeString();
        $leave_record->status_date = NULL;

        $leave_record->save();
    } 

    public function leaveBySum()
    {      
        $departments = Department::all();
        $leave_types = LeaveType::all();

        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.staff_id','leave_records.staff_name',DB::raw('sum(leave_records.day_off) day_off'),'leave_records.leave_type','leave_records.status','employees.dept_id','employees.ann_leave','employees.carry_leave','employees.sick_leave','employees.mat_leave','employees.hop_leave','employees.unp_leave','employees.spec_leave','departments.dept_name')
            ->where('leave_records.leave_type','Annual Leave')
            ->where('employees.dept_id',$dept_id)
            ->where('date_from','>=','2019-01-01')
            ->where('date_to','<=',date("Y-m-d"))
            ->where('leave_records.status','Approved')
            ->groupBy('leave_records.staff_id','leave_records.staff_name','leave_records.leave_type','leave_records.status','employees.dept_id','employees.ann_leave','employees.carry_leave','employees.sick_leave','employees.mat_leave','employees.hop_leave','employees.unp_leave','employees.spec_leave','departments.dept_name')
            ->orderBy('leave_records.staff_name', 'asc')
            ->paginate(15);
        return view('leave_report.search_by_sum')->with(['leave_records'=>$leave_records,
            'leave_types'=>$leave_types,
            'departments'=>$departments]);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchBySum(Request $request){
        $departments = Department::all();
        $leave_types = LeaveType::all();

        $this->validate($request,[
            'leave_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_type = $request->input('leave_type');
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.staff_id','leave_records.staff_name',DB::raw('sum(leave_records.day_off) day_off'),'leave_records.leave_type','leave_records.status','employees.dept_id','employees.ann_leave','employees.carry_leave','employees.sick_leave','employees.mat_leave','employees.hop_leave','employees.unp_leave','employees.spec_leave','departments.dept_name')
            ->where('leave_type',$leave_type)
            ->where('dept_id',$dept_id)
            ->where('date_from','>=',$date_from)
            ->where('date_to','<=',$date_to)
            ->groupBy('leave_records.staff_id','leave_records.staff_name','leave_records.leave_type','leave_records.status','employees.dept_id','employees.ann_leave','employees.carry_leave','employees.sick_leave','employees.mat_leave','employees.hop_leave','employees.unp_leave','employees.spec_leave','departments.dept_name')
            ->orderBy('leave_records.staff_name', 'asc')
            ->get();

        return view('leave_report.index_by_sum')->with([ 'leave_records' => 
            $leave_records ,
            'search' => true,
            'leave_types'=>$leave_types,
            'departments'=>$departments,
            'leftype' => $leave_type,
            'date_from' => $date_from,
            'date_to' => $date_to]);
    }

    public function leavePending()
    {
        /**
         *  It works the same as employeescontroller
         *  please see the comments for explaination
         *  on what's going on here.
         */        
        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('leave_records.status','Pending')
            ->where('employees.dept_id',$dept_id)
            ->orderBy('date_from', 'desc')
            ->Paginate(20);
        return view('leave_report.index_by_pending')->with('leave_records',$leave_records);
    }

    public function searchPending(Request $request){
        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $username = Auth::user()->username;
        $employee = Employee::select('dept_id')->where('staff_id',$username)->first();
        $dept_id = $employee->dept_id;

        $leave_records = DB::table('leave_records')
            ->join('employees', 'leave_records.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('leave_records.*', 'employees.dept_id','departments.dept_name')
            ->where('leave_records.status','Pending')
            ->where('employees.dept_id',$dept_id)
            ->where('date_from','>=',$date_from)
            ->where('date_to','<=',$date_to)
            ->orderBy('date_from', 'desc')
            ->get();
        return view('leave_report.search_by_pending')->with(['leave_records' => $leave_records,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
    }
	
    public function detail(Request $request){

        $staff_id = $request->get('staff_id');
        $leave_type = $request->get('type');

        $staff_info = Employee::join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('employees.staff_id','employees.staff_name','employees.functional_id','functionals.function_name','employees.location_id','locations.location_name','job_titles.job_name')
            ->where('employees.staff_id',$staff_id)
            ->first();

        $leave_records = LeaveRecord::where('staff_id',$staff_id)
        ->where('leave_type',$leave_type)
        ->where('status','Approved')
        ->orderBy('date_from', 'desc')
        ->get();

        return view('leave_record.detail')->with(['leave_records'=>$leave_records,
            'staff_info'=>$staff_info]);
    }

    public function reportExcel(Request $request)
    {
        $staff_id = $request->get('staff_id');
        $leave_type = $request->get('type');

        $leave_records = LeaveRecord::where('staff_id',$staff_id)
        ->where('leave_type',$leave_type)
        ->where('status','Approved')
        ->select("staff_id","staff_name","leave_type","date_from","date_to","day_off","unit","reason","approver","status")
        ->orderBy('date_from', 'desc')
        ->get();
            
        return Excel::create('leave_detail_excel', function($excel) use ($leave_records) {
            $excel->sheet('leave_detail', function($sheet) use ($leave_records)
            {
                $sheet->fromArray($leave_records);
            });
        })->download('xlsx');
    }

}
