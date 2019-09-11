<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class LocationsController extends Controller
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
        
        $locations = Location::paginate(100);
        return view('sys_mg.locations.index')->with('locations',$locations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.locations.create');
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
            'location_name' => 'required|min:2',
            'nick_name' => 'required|min:4',
            'location_address' => 'required|min:10'
        ]);
        $location = new Location();
        $location->location_name = $request->input('location_name');
        $location->nick_name = $request->input('nick_name');
        $location->location_address = $request->input('location_address');
        $location->save();
        return redirect('/locations')->with('info','Location has been created!');
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
        $location = Location::find($id);
        return view('sys_mg.locations.edit')->with('location',$location);
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
            'location_name' => 'required|min:2',
            'nick_name' => 'required|min:4',
            'location_address' => 'required|min:10'
        ]);
        $location = Location::find($id);
        $location->location_name = $request->input('location_name');
        $location->nick_name = $request->input('nick_name');
        $location->location_address = $request->input('location_address');
        $location->save();
        return redirect('/locations')->with('info','Selected location has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);
        $location->delete();
        return redirect('/locations')->with('info','Selected location has been deleted!');
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
        $locations = Location::where( 'location_name' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('location_name','asc')
            ->paginate(4);
        return view('sys_mg.locations.index')->with([ 'locations' => $locations ,'search' => true ]);
    }
}
