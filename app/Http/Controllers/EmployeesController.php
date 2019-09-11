<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Employee;
use App\Department;
use App\Nationality;
use App\Location;
use App\Functional;
use App\ReportingManager;
use App\JobTitle;
use App\Gender;
use DB;

class EmployeesController extends Controller
{
    /**
     *  Only authenticated users can access this controller
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
        $employees = Employee::Paginate(20);
        return view('employee.index')->with('employees',$employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         *  Get Departments so we can show department
         *  name on the department dropdown in the view
         */
        $departments = Department::orderBy('dept_name','asc')->get();
        /**
         *  this and other objects works the same as department
         */
        $nationalities = Nationality::orderBy('country_name','asc')->get();
        $locations = Location::orderBy('location_name','asc')->get();
        $jobtitles = JobTitle::orderBy('job_name','asc')->get();
        $functionals = Functional::orderBy('function_name','asc')->get();
        $reporting_managers = ReportingManager::orderBy('manager_name','asc')->get();
        $genders = Gender::orderBy('gender_name','asc')->get();
        /**
         *  return the view with an array of all these objects
         */
        return view('employee.create')->with([
            'departments'  => $departments,
            'nationalities'=> $nationalities,
            'locations'    => $locations,
            'jobtitles'    => $jobtitles,
            'functionals'  => $functionals,
            'reporting_managers'    => $reporting_managers,
            'genders'      => $genders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        /**
         *  validateRequest is a method defined in this controller
         *  which will validate  the form. we have created 
         *  it so we can reuse it in the update method with 
         *  different parameters.
         */
        $this->validateRequest($request,null);
        
        /**
         *  Note!
         *  before using storage we need to link it to 
         *  the public folder by typing the command,
         *  php artisan storage:link  
         */

        /**
         * 
         *  Handle the image file upload which will be stored
         *  in storage/app/public/employee_images
         */
        $fileNameToStore = $this->handleImageUpload($request);

        /**
         *  Create new object of Employee
         */
        $employee = new Employee();
        
        /**
         *  setEmployee is also a method of this controller
         *  which i have created, so i can use it for update 
         *  method.
         */
        $this->setEmployee($employee,$request,$fileNameToStore);
        
        return redirect('/employees')->with('info','New Employee has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employee.show')->with('employee',$employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**
         *  this is same as create but with an existing
         *  employee
         */
        $departments  = Department::orderBy('dept_name','asc')->get();
        $nationalities= Nationality::orderBy('country_name','asc')->get();
        $locations    = Location::orderBy('location_name','asc')->get();
        $jobtitles    = JobTitle::orderBy('job_name','asc')->get();
        $functionals  = Functional::orderBy('function_name','asc')->get();
        $reporting_managers    = ReportingManager::orderBy('manager_name','asc')->get();
        $genders      = Gender::orderBy('gender_name','asc')->get();

        $employee = Employee::find($id);
        return view('employee.edit')->with([
            'departments'  => $departments,
            'nationalities'=> $nationalities,
            'locations'    => $locations,
            'jobtitles'    => $jobtitles,
            'functionals'  => $functionals,
            'reporting_managers'    => $reporting_managers,
            'genders'      => $genders,
            'employee'     => $employee
        ]);
    }

    public function editApprover($id)
    {
        $employee = Employee::find($id);
        return view('employee.edit_approver')->with('employee',$employee);
    }

    public function postApprover(Request $request)
    {
        $id = $request->input('employee_id');
        $employee = Employee::find($id);
        $employee->ot_verifier = $request->input('verifier');
        $employee->ot_approver = $request->input('approver');
        $employee->save();
        
        return redirect('/employee_verifier_approver')->with('info','Verifier & Approver have been updated!');
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
        $employee = Employee::find($id);
        $old_picture = $employee->picture;
        if($request->hasFile('picture')){
            //Delete old image
            Storage::delete('uploads/employee_images/'.$employee->picture);
            //Upload new image
            $fileNameToStore = $this->handleImageUpload($request);
        }else{    
            if($id){
                $fileNameToStore = $employee->picture;
            }else{
                $fileNameToStore = '';
            }                  
        }        
        /**
         *  updating an existing employee with setEmployee
         *  method
         */
        $this->setEmployee($employee,$request,$fileNameToStore);
        return redirect('/employees/show/'.$id)->with('info','Selected Employee has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        Storage::delete('uploads/employee_images/'.$employee->picture);
        return redirect('/employees')->with('info','Selected Employee has been deleted!');
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $this->validate($request,[
            'search'   => 'required|min:1',
            'options'  => 'required'
        ]);
        $str = $request->input('search');
        $option = $request->input('options');
        $employees = Employee::where($option, 'LIKE' , '%'.$str.'%')->Paginate(20);
        return view('employee.index')->with(['employees' => $employees , 'search' => true ]);
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchByDept(Request $request){
        $departments = Department::all();
        $this->validate($request,[
            'department' => 'required'
        ]);
        $dept_id = $request->input('department');       
        $employees = Employee::where('dept_id',$dept_id)->orderBy('staff_name','asc')->get();
        return view('employee.search_by_dept')->with(['employees' => $employees , 
            'departments'=>$departments,
            'dept_id'=>$dept_id,
            'search' => true ]);
    }

    /**
     * This method is used for validating the form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    private function validateRequest($request,$id){
        /**
         *  specifying the validation rules 
         */
        /**
         *  Below in Picture validation rules we are first checking
         *  that if there is an image, if not then don't apply the
         *  validation rules. the reason we are doing this is because
         *  if we are updating an employee but not updating the image. 
         */
        return $this->validate($request,[
            'staff_id'     =>  'required|min:3|max:50',
            'staff_name'      =>  'required|min:3|max:50',
            'gender'         =>  'required',
            'nationality'    =>  'required',
            'birth_date'     =>  'required',
            'email'          =>  'required|email|max:250',
            'phone'          =>  'required|max:50', 
            'address'        =>  'required|max:500',
            'join_date'      =>  'required',         
            'department'     =>  'required',
            'functional'     =>  'required',
            'jobtitle'       =>  'required',
            'location'       =>  'required', 
            'reporting_manager'       =>  'required', 
            'work_day'       =>  'required',    
            'direct_report'  =>  'required',  
            'ann_leave'   =>  'required', 
            'sick_leave'   =>  'required',
            'mat_leave'   =>  'required',
            'hop_leave'   =>  'required',
            'unp_leave'   =>  'required',
            'spec_leave'   =>  'required',
            'carry_leave'   =>  'required',         
            'picture'        =>  ($request->hasFile('picture') ? 'required|image|max:191' : '')
            /**
             *  if we are updating an employee but not changing the
             *  email then this will throw a validation error saying
             *  that email should be unique. that's why we need to specify
             *  the current employee to ignore the unique validation rule.
             *  Above in email rules , we are using a ternary operator simply
             *  saying that if we pass an id then it will ignore that employee
             *  (which we want in update) and if id's null then it will check
             *  every employee to be unique (which we want in create because
             *  every employee should have a unique email).
             *  check the documentation for more details, 
             *  https://laravel.com/docs/5.6/validation#rule-unique 
             */

            
        ]);
    }

    /**
     * Save a new resource or update an existing resource.
     *
     * @param  App\Employee $employee
     * @param  \Illuminate\Http\Request  $request
     * @param  string $fileNameToStore
     * @return Boolean
     */
    private function setEmployee(Employee $employee,Request $request,$fileNameToStore){
        $employee->staff_id   = $request->input('staff_id');
        $employee->staff_name    = $request->input('staff_name');
        $employee->gender_id    = $request->input('gender');
        $employee->nationality_id   = $request->input('nationality');
        //Format Date then insert it to the database
        $employee->birth_date   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('birth_date'))));
        $employee->email        = $request->input('email');
        $employee->phone        = $request->input('phone');
        $employee->address      = $request->input('address');
        //Format Date then insert it to the database
        $employee->join_date    = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('join_date'))));
        $employee->dept_id      = $request->input('department');
        $employee->functional_id    = $request->input('functional');
        $employee->job_title_id     = $request->input('jobtitle');
        $employee->location_id      = $request->input('location');       
        $employee->reporting_manager_id  = $request->input('reporting_manager');
        $employee->work_day    = $request->input('work_day');
        $employee->have_direct_report    = $request->input('direct_report');
        $employee->ann_leave    = $request->input('ann_leave');
        $employee->sick_leave    = $request->input('sick_leave');
        $employee->mat_leave    = $request->input('mat_leave');
        $employee->hop_leave    = $request->input('hop_leave');
        $employee->unp_leave    = $request->input('unp_leave');
        $employee->spec_leave    = $request->input('spec_leave');
        $employee->carry_leave    = $request->input('carry_leave');
        /**
         *  we are checking if there is an image
         *  because if we are updating an employee
         *  but not changing the employee image then
         *  it will save  '' (means null) to picture field and we don't
         *  want that. 
         */
        if($fileNameToStore){
            $employee->picture = $fileNameToStore;
        }else{
            $employee->picture = 'employee-male.png';
        }
        
        $employee->save();
    }

    /**
     * Handle image upload when creating a new resource
     * or updating an existing resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handleImageUpload(Request $request){

        $fileNameToStore = '';

        if( $request->hasFile('picture') ){
            
            //get filename with extension
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            
            //get just filename
            $filename = pathInfo($filenameWithExt,PATHINFO_FILENAME);
            
            // get just extension
            $extension = $request->file('picture')->getClientOriginalExtension();
            
            /**
             * filename to store
             * 
             *  we are appending timestamp to the file name
             *  and prepending it to the file extension just to
             *  make the file name unique.
             */
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            
            //upload the image
            $path = $request->file('picture')->storeAs('employee_images', $fileNameToStore, 'public_uploads');
        }
        /**
         *  return the file name so we can add it to database.
         */
        return $fileNameToStore;
    }

    public function department()
    {      
        $departments = Department::all();
        $employees = Employee::orderBy('staff_name','asc')->Paginate(20);
        return view('employee.index_by_dept')->with(['employees'=>$employees,           
            'departments'=>$departments]);
    }

    public function getVerApp()
    {
        $departments = Department::all();
        $employees = Employee::where('dept_id',6)->orderBy('staff_name','asc')->get();
        return view('employee.index_by_approver')->with(['employees'=>$employees,           
            'departments'=>$departments]);
    }

    public function postVerApp(Request $request){
        $departments = Department::all();
        $this->validate($request,[
            'department' => 'required'
        ]);
        $dept_id = $request->input('department'); 
        $dept2 = Department::where('id',$dept_id)->first();  
        $dept_name = $dept2->dept_name;   
        $employees = Employee::where('dept_id',$dept_id)->orderBy('staff_name','asc')->get();
        return view('employee.search_by_approver')->with(['employees' => $employees , 
            'departments'=>$departments,
            'dept_id'=>$dept_id,
            'dept_name'=>$dept_name,
            'search' => true ]);
    }
	
    public function filterDept(Request $request)
    {      
        $dept_id = $request->dept_id;
        $function_options = Functional::where('dept_id',$dept_id)->get();

        return $function_options;
    }

    public function filterFunct(Request $request)
    {      
        $function_id = $request->function_id;
        $job_options = JobTitle::where('function_id',$function_id)->get();

        return $job_options;
    }

}
