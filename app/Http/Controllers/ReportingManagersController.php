<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportingManager;

class ReportingManagersController extends Controller
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
        
        $reportingmanagers = ReportingManager::Paginate(200);
        return view('sys_mg.reportingmanagers.index')->with('reportingmanagers',$reportingmanagers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.reportingmanagers.create');
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
            'manager_name' => 'required|min:2',
            'email' => 'required|email|max:50'
        ]);
        $reportingmanager = new ReportingManager();
        $reportingmanager->manager_name = $request->input('manager_name');
        $reportingmanager->email = $request->input('email');
        $reportingmanager->save();
        return redirect('/reportingmanagers')->with('info','Reporting Manager has been created!');
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
        $reportingmanager = ReportingManager::find($id);
        return view('sys_mg.reportingmanagers.edit')->with('reportingmanager',$reportingmanager);
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
            'manager_name' => 'required|min:2',
            'email' => 'required|email|max:50'
        ]);
        $reportingmanager = ReportingManager::find($id);
        $reportingmanager->manager_name = $request->input('manager_name');
        $reportingmanager->email = $request->input('email');
        $reportingmanager->save();
        return redirect('/reportingmanagers')->with('info','Selected Reporting Manager has been updated!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reportingmanager = ReportingManager::find($id);
        $reportingmanager->delete();
        return redirect('/reportingmanagers')->with('info','Selected Reporting Manager has been deleted!');
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
        $reportingmanagers = ReportingManager::where( 'manager_name' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('manager_name','asc')
            ->paginate(10);
        return view('sys_mg.reportingmanagers.index')->with([ 'reportingmanagers' => $reportingmanagers ,'search' => true ]);
    }
}
