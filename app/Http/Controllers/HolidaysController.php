<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HolidaysController extends Controller
{
    /**
     *  Only authenticated holidays can access this controller
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
        
        $holidays = Holiday::orderBy('date_from','asc')->Paginate(30);
        return view('holiday.index')->with('holidays',$holidays);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holiday.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holiday = new Holiday();
        $this->validateRequest($request,NULL);
        $this->setHoliday($request ,$holiday);
        return redirect('/holidays')->with('info','New holiday has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $holiday = Holiday::find($id);
        return view('holiday.edit')
            ->with('holiday',$holiday);
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
        $holiday = Holiday::find($id);
        $this->setHoliday($request, $holiday);

        return redirect('/holidays')->with('info','selected holiday has been updated');
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
         *  Check if the holiday is not the
         *  current authenticated holiday
         */
        
        $holiday = Holiday::find($id);
        $holiday->delete();
        return redirect('/holidays')->with('info','selected holiday has been deleted!');
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $this->validate($request,[
            'search' => 'required',
            'options' => 'required',
        ]);
        $str = $request->input('search');
        $option = $request->input('options');
        $holidays = Holiday::where( $option , 'LIKE' , '%'.$str.'%' )
            ->orderBy($option,'asc')
            ->paginate(30);
        return view('holiday.index')->with([ 'holidays' => $holidays ,'search' => true ]);
    }

    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
            'year'   =>  'required|min:4',            
            'hol_name'    =>  'required|min:5',
            'day_off'    =>  'required|min:1',
            'date_from'    =>  'required',
            'date_to'    =>  'required'
        ]);
    }

    /**
     * Add or update an holiday
     */
    private function setHoliday(Request $request , Holiday $holiday){
        $holiday->year = $request->input('year');
        $holiday->hol_name = $request->input('hol_name');
        $holiday->day_off = $request->input('day_off');
        //Format Date then insert it to the database
        $holiday->date_from   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_from'))));
        $holiday->date_to   = date('Y-m-d', strtotime(str_replace('-', '/', $request->input('date_to'))));

        $holiday->save();
    }   
}
