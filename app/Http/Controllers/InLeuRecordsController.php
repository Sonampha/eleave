<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InLeu;
use App\LeaveType;
use App\ReportingManager;
use App\Department;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;

class InLeuRecordsController extends Controller
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
        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->select('in_leus.*', 'employees.staff_name')
            ->orderBy('inleu_date', 'asc')
            ->Paginate(30);
        return view('leave_in_leu.index')->with('in_leus',$in_leus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('leave_in_leu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $in_leu = new InLeu();
        $this->validateRequest($request,NULL);
        $this->setInLeu($request ,$in_leu);
        return redirect('/inleus/in_leu_records')->with('info','New In Leu Record has been Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $in_leu = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
                    ->select('in_leus.*', 'employees.staff_name')
                    ->find($id);
        return view('leave_in_leu.show')->with('in_leu',$in_leu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $in_leu = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
                    ->select('in_leus.*', 'employees.staff_name')
                    ->find($id);
        return view('leave_in_leu.edit')->with('in_leu',$in_leu);
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
        $in_leu = InLeu::find($id);
        $this->setInLeu($request, $in_leu);

        return redirect('/inleus/in_leu_records')->with('info','Selected In Leu Record has been Updated');
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
         *  Check if the in_leu is not the
         *  current authenticated in_leu
         */
        
        $in_leu = InLeu::find($id);
        $in_leu->delete();
        return redirect('/inleus/in_leu_records')->with('info','Selected In Leu Record has been Deleted!');
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
        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->select('in_leus.*', 'employees.staff_name')
            ->where('inleu_date','>=',$date_from)
            ->where('inleu_date','<=',$date_to)
            ->orderBy('inleu_date', 'asc')
            ->paginate(15);
        return view('leave_in_leu.index')->with([ 'in_leus' => $in_leus,
            'search' => true]);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search2(Request $request){
        $departments = Department::all();        

        $this->validate($request,[
            'department' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
        $dep_id = $request->input('department');
        $date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('in_leus.*', 'employees.staff_name','departments.dept_name')
            ->where('dept_id',$dep_id)
            ->where('inleu_date','>=',$date_from)
            ->where('inleu_date','<=',$date_to)
            ->orderBy('inleu_date', 'asc')
            ->get();

        return view('leave_in_leu.index_department')->with([ 'in_leus' => $in_leus ,
            'search' => true,
            'departments'=>$departments,
            'dep_id' => $dep_id,
            'date_from' => $date_from,
            'date_to' => $date_to]);
    }

    public function search3(Request $request){
        if($request->department == ''){
            return response()->json(['info'=>'Please select a department!']);
        }       
        
        $dep_id = $request->department;

        $employees = Employee::join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('employees.*','departments.dept_name')
            ->where('dept_id',$dep_id)
            ->orderBy('employees.staff_name', 'asc')
            ->get();

        foreach($employees as $employee){
                $dept_name = $employee->dept_name;
                $staff_name = $employee->staff_name;
                $staff_id = $employee->staff_id;

                $return_arr[] = array("dept_name" => $dept_name,
                                "staff_name" => $staff_name,
                                "staff_id" => $staff_id);
            }

        // Encoding array in JSON format
        return response()->json(['return_arr'=>$return_arr]);
    }

    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
            'staff_id'     =>  'required|min:3|max:50',
            'inleu_date'   =>  'required',
            'inleu_day'    =>  'required',
            'reason'       =>  'required|max:190'
        ]);
    }

    /**
     * Add or update an in_leu
     */
    private function setInLeu(Request $request , InLeu $in_leu){
        $in_leu->staff_id = $request->input('staff_id');
        //Format Date then insert it to the database
        $in_leu->inleu_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('inleu_date'))));
        $in_leu->inleu_day = $request->input('inleu_day');
        $in_leu->reason = $request->input('reason');
        $in_leu->save();
    } 

    public function department()
    {      
        $departments = Department::all();
        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('in_leus.*', 'employees.staff_name','departments.dept_name')
            ->orderBy('inleu_date', 'asc')
            ->paginate(15);
        return view('leave_in_leu.search_department')->with(['in_leus'=>$in_leus,
            'departments'=>$departments]);
    }

    public function addDepartment()
    {      
        $departments = Department::all();
        return view('leave_in_leu.add_department')->with(['departments'=>$departments]);
    }

   public function postInleu(Request $request){  
        $current_date = Carbon::now()->toDateTimeString();    
        //loop array num_days  
        for ($i = 0; $i < count($request->array_staff); $i++) {
            $data[] = [
                'inleu_date' => $request->date_iso,
                'staff_id' => $request->array_staff[$i],
                'inleu_day' => $request->array_num[$i],
                'reason' => $request->reason,
                'created_at' => $current_date,
                'updated_at' => $current_date
            ];
        }
        /* Save Data to New In-Leu Record*/
        $success = InLeu::insert($data);

        if($success){            
            return response()->json(['msg'=>'New In-Leu has been added successfully.']);
        }else{
            return response()->json('info','Failed! to add In-Leu.');
        }       
   }

    public function indexBySum()
    {      
        $departments = Department::all();
        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('in_leus.staff_id',DB::raw('sum(in_leus.inleu_day) inleu_day'),'employees.staff_name','employees.dept_id','departments.dept_name')
            ->groupBy('in_leus.staff_id','employees.staff_name','employees.dept_id','departments.dept_name')
            ->orderBy('inleu_date', 'asc')
            ->paginate(15);
        return view('leave_in_leu.search_sum')->with(['in_leus'=>$in_leus,
            'departments'=>$departments]);
    }

    public function searchBySum(Request $request){
        $departments = Department::all();        

        $this->validate($request,[
            'department' => 'required',
        ]);
        $dep_id = $request->input('department');

        $in_leus = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')
            ->join('departments', 'employees.dept_id', '=', 'departments.id')
            ->select('in_leus.staff_id',DB::raw('sum(in_leus.inleu_day) inleu_day'),'employees.staff_name','employees.dept_id','departments.dept_name')
            ->where('dept_id',$dep_id)
            ->groupBy('in_leus.staff_id','employees.staff_name','employees.dept_id','departments.dept_name')
            ->orderBy('employees.staff_name', 'asc')
            ->get();

        return view('leave_in_leu.index_sum')->with([ 'in_leus' => $in_leus ,
            'departments'=>$departments,
            'dep_id' => $dep_id]);
    }

    public function detail(Request $request){

        $staff_id = $request->get('staff_id');

        $inleu_records = InLeu::join('employees', 'in_leus.staff_id', '=', 'employees.staff_id')->select('in_leus.*','employees.staff_name')
            ->where('in_leus.staff_id',$staff_id)
            ->orderBy('in_leus.inleu_date', 'asc')
            ->get();

        return view('leave_in_leu.detail')->with(['inleu_records' => $inleu_records]);
    }


}
