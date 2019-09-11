<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveRecord;
use App\LeaveType;
use App\ReportingManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Mail\LeaveTaskMail;
use App\Mail\LeaveRejectMail;
use Mail;
use DB;

class MyLeaveTasksController extends Controller
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
        $my_name = Auth::user()->full_name;
        $leave_records = LeaveRecord::where('approver',$my_name)
        ->where('status','Pending')
        ->orderBy('date_from', 'desc')
        ->paginate(100);
        return view('my_leave_task.index')->with('leave_records',$leave_records);
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
        return view('my_leave_task.create')->with(['leave_types'=>$leave_types,'reporting_managers'=>$reporting_managers]);
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
        return redirect('/my_leave_tasks')->with('info','New leave record has been created!');
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
        return view('my_leave_task.show')->with('leave_record',$leave_record);
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
        return view('my_leave_task.edit')
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

        return redirect('/my_leave_tasks')->with('info','Selected Leave Record has been Updated');
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
        return redirect('/my_leave_tasks')->with('info','Selected Leave Record has been Deleted!');
    }

    /**
     * Approve the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $leave_record = LeaveRecord::find($id);
        $staff_id = $leave_record->staff_id;
        $user = DB::table('users')->where('username',$staff_id)->first();

        $data = [
                'staff_name' => $user->full_name,
                'man_name' => Auth::user()->full_name,
                'staff_email' => $user->email,
                'man_email' => Auth::user()->email,
            ];
        Mail::send(new LeaveTaskMail($data));
        /**
         *  Check if the leave_record is not the
         *  current authenticated leave_record
         */
        $date_current = Carbon::now()->toDateTimeString();

        $leave_record->status = $request->input('status');
        $leave_record->status_date = $date_current;
        $leave_record->save();
        return redirect('/my_leave_tasks')->with('info','Selected Leave Request has been Approved!');
    }

    /**
     * Reject the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $id)
    {
        $leave_record = LeaveRecord::find($id);
        $staff_id = $leave_record->staff_id;
        $user = DB::table('users')->where('username',$staff_id)->first();

        $data = [
                'staff_name' => $user->full_name,
                'man_name' => Auth::user()->full_name,
                'staff_email' => $user->email,
                'man_email' => Auth::user()->email,
            ];
        Mail::send(new LeaveRejectMail($data));

        /**
         *  Check if the leave_record is not the
         *  current authenticated leave_record
         */
        $date_current = Carbon::now()->toDateTimeString();

        $leave_record->status = $request->input('status');
        $leave_record->status_date = $date_current;
        $leave_record->save();
        return redirect('/my_leave_tasks')->with('info','Selected Leave Request has been Rejected!');
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

        $leave_records = LeaveRecord::where('date_from','>=',$date_from)
        ->where('date_to','<=',$date_to)
        ->where('approver',$my_name)
        ->orderBy('date_from', 'desc')
        ->paginate(100);
        return view('my_leave_task.index')->with([ 'leave_records' => $leave_records ,'search' => true ]);
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
        $leave_record->status_date = NULL;

        $leave_record->save();
    }  
}
