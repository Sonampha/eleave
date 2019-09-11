<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nationality;

class NationalitiesController extends Controller
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
        /**
         *  read all the comments from DepartmentsController
         *  they are all the same.
         */
        
        $nationalities = Nationality::Paginate(10);
        return view('sys_mg.nationalities.index')->with('nationalities',$nationalities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.nationalities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'country_name' => 'required|unique:nationalities|min:3'
        ]);
        $nationality = new Nationality();
        $nationality->country_name = $request->input('country_name');
        $nationality->save();
        return redirect('/nationalities')->with('info','New Nationality has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nationality = Nationality::find($id);
        return view('sys_mg.nationalities.edit')->with('nationality',$nationality);
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
            'country_name' => 'required|min:3|unique:nationalities'
        ]);

        $nationality = Nationality::find($id);
        $nationality->country_name = $request->input('country_name');
        $nationality->save();
        return redirect('/nationalities')->with('info','Selected Nationality has been Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nationality = Nationality::find($id);
        $nationality->delete();
        return redirect('/nationalities')->with('info','Selected Nationality has been deleted!');
    }

    /**
     *  Search For Resource(s)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        $this->validate($request,[
            'search' => 'required'
        ]);
        $str = $request->input('search');
        $nationalities = nationality::where( 'country_name' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('country_name','asc')
            ->paginate(10);
        return view('sys_mg.nationalities.index')->with([ 'nationalities' => $nationalities ,'search' => true ]);
    }
}
