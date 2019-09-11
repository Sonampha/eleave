<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobTitle;

class JobTitlesController extends Controller
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
        
        $jobtitles = JobTitle::Paginate(10);
        return view('sys_mg.jobtitles.index')->with('jobtitles',$jobtitles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.jobtitles.create');
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
            'job_name' => 'required|min:2'
        ]);
        $jobtitle = new JobTitle();
        $jobtitle->job_name = $request->input('job_name');        
        $jobtitle->save();
        return redirect('/jobtitles')->with('info','Job Title has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobtitle = JobTitle::find($id);
        return view('sys_mg.jobtitles.edit')->with('jobtitle',$jobtitle);
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
            'job_name' => 'required|min:2'
        ]);
        $jobtitle = JobTitle::find($id);
        $jobtitle->job_name = $request->input('job_name');
        $jobtitle->save();
        return redirect('/jobtitles')->with('info','Selected Job Title has been updated!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobtitle = JobTitle::find($id);
        $jobtitle->delete();
        return redirect('/jobtitles')->with('info','Selected Job Title has been deleted!');
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
        $jobtitles = JobTitle::where( 'job_name' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('job_name','asc')
            ->paginate(10);
        return view('sys_mg.jobtitles.index')->with([ 'jobtitles' => $jobtitles ,'search' => true ]);
    }
}
