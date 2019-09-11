<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\OtRecord;
use App\OtReason;
use App\OtHour;
use App\OtMin;
use App\Functional;
use App\Location;
use App\Employee;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class OvertimeController extends Controller
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
        $ot_reasons = OtReason::all();
        $ot_hours = OtHour::all();
        $ot_mins = OtMin::all();
        $current_date = Carbon::now()->toDateTimeString();        

        return view('overtime.index')
            ->with([
                'ot_reasons'  =>  $ot_reasons,
                'ot_hours'  =>  $ot_hours,
                'ot_mins'  =>  $ot_mins,
                'current_date'    =>  $current_date
            ]);
    }

   public function postOvertime(Request $request){
        $staff_id = Auth::user()->username;
        $staff_name = Auth::user()->full_name;

        /* Validat OT date */       
        if($request->ot_date == ''){  
            return response()->json(['info'=>'Sorry, overtime date cannot be empty!']);
        }

        /* Validat OT minute */       
        if($request->ot_minute <= 0){  
            return response()->json(['info'=>'Sorry, overtime cannot be negative or zero!']);
        }

        /* Validat OT minute */       
        if($request->ot_remark == ''){  
            return response()->json(['info'=>'Please write your remark!']);
        }

        $ot_date   = date('Y-m-d', strtotime(str_replace('-', '/', $request->ot_date)));
        $ot_type = $this->checkday($ot_date);
        $current_date = Carbon::now()->toDateTimeString(); 
        $employee = Employee::where('staff_id',$staff_id)->first();

        if($employee->ot_verifier != ''){
            /* Save Data to New Overtime Record*/
            $ot_record = new OtRecord();
            $ot_record->submit_date = $current_date;
            $ot_record->staff_id = $staff_id;
            $ot_record->staff_name = $staff_name;
            $ot_record->ot_date = $ot_date;        
            $ot_record->time_from   = $request->time_from;
            $ot_record->time_to   = $request->time_to;
            $ot_record->ot_minute = $request->ot_minute;
            $ot_record->ot_reason_id = $request->ot_reason_id; 
            $ot_record->ot_remark = $request->ot_remark; 
            $ot_record->ot_type = $ot_type;
            $ot_record->verify_by = $employee->ot_verifier;
            $ot_record->verify_status = 'Pending';
            $ot_record->save();      

            return response()->json(['msg'=>'Your O.T request has been created successfully.']);

        }else{
            return response()->json(['info'=>'Sorry, you are not allowed to have O.T']);
        }

      
   }

    public function checkday($ot_date)
    {
        // best stored as array, so you can add more than one
        $holidays = ['2019-01-01','2019-01-07',                     
                     '2019-02-19',
                     '2019-03-08',
                     '2019-04-15','2019-04-16','2019-04-17',
                     '2019-05-01','2019-05-13','2019-05-14','2019-05-15',
                     '2019-05-20','2019-05-22',
                     '2019-06-18',
                     '2019-09-24','2019-09-27','2019-09-30',
                     '2019-10-15','2019-10-23','2019-10-29',
                     '2019-11-11','2019-11-12',
                     '2019-12-10'];

        if(in_array($ot_date, $holidays)) {
            return 'Sun & Holiday';
        }

        $weekDay = date('w', strtotime($ot_date));
        if ($weekDay == 0){
            return 'Sun & Holiday';
        }

        return 'Normal Day';
    }

    public function myOvertime()
    {
        $year_2019 = date('2019-1-1');
        $username = Auth::user()->username;        
        $ot_records = OtRecord::where('staff_id',$username)
        ->where('ot_date','>=',$year_2019)
        ->orderBy('ot_date', 'desc')
        ->paginate(100);
        return view('overtime.my_overtime')->with('ot_records',$ot_records);
    }

    public function postMyOvertime(Request $request){

        $this->validate($request,[
            'date_from' => 'required',
            'date_to' => 'required',
        ]);

        $username = Auth::user()->username;
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));
        
        $ot_records = OtRecord::where('staff_id',$username)
        ->where('ot_date','>=',$date_from)
        ->where('ot_date','<=',$date_to)
        ->orderBy('ot_date', 'desc')
        ->get();

        return view('overtime.my_overtime_search')->with([ 'ot_records' => 
            $ot_records ,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
    }

    public function show($id)
    {
        $ot_record = OtRecord::find($id);
        return view('overtime.show')->with('ot_record',$ot_record);
    }

    public function verify()
    {
        $username = Auth::user()->username;  
        $my_name = Auth::user()->full_name;
        $ot_records = OtRecord::where('verify_by',$my_name)
        ->where('verify_status','Pending')
        ->orderBy('ot_date', 'desc')
        ->paginate(100);
        return view('overtime.verify')->with('ot_records',$ot_records);
    }

    public function postVerify(Request $request, $id)
    {
        $staff_id = $request->input('staff_id');
        $employee = Employee::where('staff_id',$staff_id)->first();

        $date_current = Carbon::now()->toDateTimeString();
        $ot_record = OtRecord::find($id);
        $ot_record->verify_status = $request->input('status');
        $ot_record->verify_date = $date_current;
        $ot_record->approve_by = $employee->ot_approver;
        $ot_record->approve_status = 'Pending';
        $ot_record->save();
        return redirect('/overtime/verify')->with('info','Selected O.T Request has been Verified!');
    }

    public function rejectVerify(Request $request, $id)
    {
        $date_current = Carbon::now()->toDateTimeString();
        $ot_record = OtRecord::find($id);
        $ot_record->verify_status = $request->input('status');
        $ot_record->verify_date = $date_current;
        $ot_record->save();
        return redirect('/overtime/verify')->with('info','Selected O.T Request has been Rejected!');
    }

    public function approve()
    {
        $username = Auth::user()->username;  
        $my_name = Auth::user()->full_name;
        $ot_records = OtRecord::where('approve_by',$my_name)
        ->where('approve_status','Pending')
        ->orderBy('ot_date', 'desc')
        ->paginate(100);
        return view('overtime.approve')->with('ot_records',$ot_records);
    }

    public function postApprove(Request $request, $id)
    {
        $staff_id = Auth::user()->username;

        $date_current = Carbon::now()->toDateTimeString();
        $ot_record = OtRecord::find($id);
        $ot_record->approve_status = $request->input('status');
        $ot_record->approve_date = $date_current;
        $ot_record->save();
        return redirect('/overtime/approve')->with('info','Selected O.T request has been Approved!');
    }

    public function rejectApprove(Request $request, $id)
    {
        $date_current = Carbon::now()->toDateTimeString();
        $ot_record = OtRecord::find($id);
        $ot_record->approve_status = $request->input('status');
        $ot_record->approve_date = $date_current;
        $ot_record->save();
        return redirect('/overtime/approve')->with('info','Selected O.T request has been Rejected!');
    }

    public function cancel(Request $request, $id)
    {

        $ot_record = OtRecord::find($id);
        $ot_record->verify_status = $request->input('status');
        $ot_record->verify_by = NULL;
        $ot_record->verify_date = NULL;
        $ot_record->save();
        return redirect('/overtime/myovertime')->with('info','Selected O.T request has been Cancelled!');
    }

    public function reportBySum()
    {     
        $date1 = date('Y-m-1');
        $date2 = date('Y-m-d');
        $functionals = Functional::all();
        $locations = Location::all();

        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.staff_id','ot_records.staff_name',DB::raw('sum(ot_records.ot_minute) ot_minute'),'ot_records.approve_status','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->where('employees.functional_id',9)
            ->where('employees.location_id',5)
            ->where('ot_date','>=',$date1)
            ->where('ot_date','<=',$date2)
            ->where('ot_records.approve_status','Yes')
            ->groupBy('ot_records.staff_id','ot_records.staff_name','ot_records.approve_status','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->orderBy('ot_records.staff_name', 'asc')
            ->paginate(15);
        return view('overtime.report_by_sum')->with(['ot_records'=>$ot_records, 'date_from'=>$date1,'date_to'=>$date2,'functionals'=>$functionals,'locations'=>$locations]);
    }

    public function searchBySum(Request $request){

        $functionals = Functional::all();
        $locations = Location::all();
        $this->validate($request,[
            'functional' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $function_id = $request->input('functional');
        $location_id = $request->input('location');
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.staff_id','ot_records.staff_name',DB::raw('sum(ot_records.ot_minute) ot_minute'),'ot_records.approve_status','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->where('employees.functional_id',$function_id)
            ->where('employees.location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->groupBy('ot_records.staff_id','ot_records.staff_name','ot_records.approve_status','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->orderBy('ot_records.staff_name', 'asc')
            ->get();

        return view('overtime.search_by_sum')->with([ 'ot_records' => 
            $ot_records ,
            'functionals'=>$functionals,
            'locations'=>$locations,
            'function_id' => $function_id,
            'location_id' => $location_id,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
    }

    public function detail(Request $request){

        $staff_id = $request->get('staff_id');
        $date_from = $request->get('date1');
        $date_to = $request->get('date2');
		
        $ot_person = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.staff_id','ot_records.staff_name','employees.functional_id','functionals.function_name','employees.location_id','locations.location_name','job_titles.job_name')
            ->where('ot_records.staff_id',$staff_id)
            ->first();

        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.staff_id','ot_records.staff_name','ot_records.ot_date','ot_records.ot_reason_id','ot_records.ot_remark','ot_records.time_from','ot_records.time_to','ot_records.ot_minute','ot_records.approve_status','ot_records.ot_type','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->where('ot_records.staff_id',$staff_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.ot_date', 'asc')
            ->get();

        return view('overtime.detail')->with(['ot_records' => $ot_records,
            'ot_person'=>$ot_person,
            'date_from'=>$date_from,
            'date_to'=>$date_to]);
    }


    public function indexExport()
    {     
        $functionals = Functional::all();
        $locations = Location::all();
        $date1 = date('Y-m-1');
        $date2 = date('Y-m-d');
        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.id','ot_records.ot_date','ot_records.staff_id','ot_records.staff_name','ot_records.ot_minute','ot_records.ot_type','ot_records.ot_reason_id','ot_records.ot_remark','ot_records.approve_by','ot_records.approve_date','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->where('employees.functional_id',9)
            ->where('employees.location_id',5)
            ->where('ot_date','>=',$date1)
            ->where('ot_date','<=',$date2)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.staff_name', 'asc')
            ->paginate(15);
        return view('overtime.export_index')->with(['ot_records'=>$ot_records, 'date_from'=>$date1,'date_to'=>$date2,'functionals'=>$functionals,'locations'=>$locations]);
    }

    public function postExport(Request $request){

        $functionals = Functional::all();
        $locations = Location::all();
        $this->validate($request,[
            'functional' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $function_id = $request->input('functional');
        $location_id = $request->input('location');
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.id','ot_records.ot_date','ot_records.staff_id','ot_records.staff_name','ot_records.ot_minute','ot_records.ot_type','ot_records.ot_reason_id','ot_records.ot_remark','ot_records.approve_by','ot_records.approve_date','employees.functional_id','employees.location_id','employees.job_title_id','functionals.function_name','locations.location_name','job_titles.job_name')
            ->where('employees.functional_id',$function_id)
            ->where('employees.location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.staff_name', 'asc')
            ->get();

        return view('overtime.export_post')->with([ 'ot_records' => 
            $ot_records ,
            'functionals'=>$functionals,
            'locations'=>$locations,
            'function_id' => $function_id,
            'location_id' => $location_id,
            'date_from' => $date_from,
            'date_to' => $date_to ]);
    }

    public function expDetail(Request $request){

        $record_id = $request->get('record_id');
        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->select('ot_records.staff_id','ot_records.staff_name','ot_records.ot_type','ot_records.ot_date','ot_records.time_from','ot_records.time_to','ot_records.ot_minute','ot_records.ot_reason_id','ot_records.ot_remark')
            ->where('ot_records.id',$record_id)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.ot_date', 'asc')
            ->get();

        return view('overtime.export_detail')->with(['ot_records' => $ot_records]);
    }

    public function exportExcel(Request $request)
    {
        $function_id = $request->get('funct');
        $location_id = $request->get('loc');
        $date_from = $request->get('from');
        $date_to = $request->get('to');
        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('ot_reasons', 'ot_reasons.id', '=', 'ot_records.ot_reason_id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->select('functionals.function_name as Function','ot_records.staff_name as Staff_Name','ot_records.ot_date as OT_Date','ot_records.time_from as From','ot_records.time_to as To','ot_records.ot_minute as Minute','ot_reasons.ot_reason as Reason','ot_records.ot_remark as Remark','ot_records.verify_status as Verify','ot_records.verify_date as Verify_Date','ot_records.verify_by as Verifier','ot_records.approve_status as Approve','ot_records.approve_date as Approve_Date','ot_records.approve_by as Approver','ot_records.ot_type as OT_Type','locations.location_name as Location')
            ->where('functional_id',$function_id)
            ->where('location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.staff_name', 'asc')
            ->get();
            
        return Excel::create('ot_export_excel', function($excel) use ($ot_records) {
            $excel->sheet('overtime', function($sheet) use ($ot_records)
            {
                $sheet->fromArray($ot_records);
            });
        })->download('xlsx');
    }

    public function exportCsv(Request $request)
    {
        $function_id = $request->get('funct');
        $location_id = $request->get('loc');
        $date_from = $request->get('from');
        $date_to = $request->get('to');
        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('ot_reasons', 'ot_reasons.id', '=', 'ot_records.ot_reason_id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->select('functionals.function_name as Function','ot_records.staff_name as Staff_Name','ot_records.ot_date as OT_Date','ot_records.time_from as From','ot_records.time_to as To','ot_records.ot_minute as Minute','ot_reasons.ot_reason as Reason','ot_records.ot_remark as Remark','ot_records.verify_status as Verify','ot_records.verify_date as Verify_Date','ot_records.verify_by as Verifier','ot_records.approve_status as Approve','ot_records.approve_date as Approve_Date','ot_records.approve_by as Approver','ot_records.ot_type as OT_Type','locations.location_name as Location')
            ->where('functional_id',$function_id)
            ->where('location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.staff_name', 'asc')
            ->get();
            
        return Excel::create('ot_export_csv', function($excel) use ($ot_records) {
            $excel->sheet('overtime', function($sheet) use ($ot_records)
            {
                $sheet->fromArray($ot_records);
            });
        })->download('csv');
    }

    public function exportPdf(Request $request){
        $function_id = $request->get('funct');
        $location_id = $request->get('loc');
        $date_from = $request->get('from');
        $date_to = $request->get('to');
        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('ot_reasons', 'ot_reasons.id', '=', 'ot_records.ot_reason_id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->select('functionals.function_name','ot_records.staff_name','ot_records.ot_date','ot_records.time_from','ot_records.time_to','ot_records.ot_minute','ot_reasons.ot_reason','ot_records.ot_remark','ot_records.verify_status','ot_records.verify_date','ot_records.verify_by','ot_records.approve_status','ot_records.approve_date','ot_records.approve_by','ot_records.ot_type','locations.location_name')
            ->where('functional_id',$function_id)
            ->where('location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.staff_name', 'asc')
            ->get();
        //generate pdf
        $pdf = PDF::loadView('overtime.ot_export_pdf',['ot_records' => $ot_records])->setPaper('a4', 'landscape');
        return $pdf->stream('overtime_record'.'.pdf');
    }
	
    public function reportExcel(Request $request)
    {
        $staff_id = $request->get('staff_id');
        $function_id = $request->get('funct');
        $location_id = $request->get('loc');
        $date_from = $request->get('from');
        $date_to = $request->get('to');

        $ot_records = OtRecord::join('employees', 'ot_records.staff_id', '=', 'employees.staff_id')->join('functionals', 'employees.functional_id', '=', 'functionals.id')->join('ot_reasons', 'ot_reasons.id', '=', 'ot_records.ot_reason_id')->join('locations', 'employees.location_id', '=', 'locations.id')
            ->select('functionals.function_name as Function','ot_records.staff_name as Staff_Name',DB::raw("DATE_FORMAT(ot_records.ot_date,'%d-%b-%Y') as OT_Date"),'ot_records.time_from as From','ot_records.time_to as To','ot_records.ot_minute as Minute','ot_reasons.ot_reason as Reason','ot_records.ot_remark as Remark','ot_records.verify_status as Verify',
                DB::raw("DATE_FORMAT(ot_records.verify_date,'%d-%b-%Y') as Verify_Date"),'ot_records.verify_by as Verifier','ot_records.approve_status as Approve',DB::raw("DATE_FORMAT(ot_records.approve_date,'%d-%b-%Y') as Approve_Date"),'ot_records.approve_by as Approver','ot_records.ot_type as OT_Type','locations.location_name as Location')
            ->where('ot_records.staff_id',$staff_id)
            ->where('functional_id',$function_id)
            ->where('location_id',$location_id)
            ->where('ot_date','>=',$date_from)
            ->where('ot_date','<=',$date_to)
            ->where('ot_records.approve_status','Yes')
            ->orderBy('ot_records.OT_Date', 'asc')
            ->get();
            
        return Excel::create('ot_export_excel', function($excel) use ($ot_records) {
            $excel->sheet('overtime', function($sheet) use ($ot_records)
            {
                $sheet->fromArray($ot_records);
            });
        })->download('xlsx');
    }

}
