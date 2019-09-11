<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functional;

class FunctionalsController extends Controller
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
        
        $functionals = Functional::paginate(15);
        return view('sys_mg.functionals.index')->with('functionals',$functionals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sys_mg.functionals.create');
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
            'function_name' => 'required|min:2|unique:functionals'
        ]);
        $functional = new Functional();
        $functional->function_name = $request->input('function_name');
        $functional->save();
        return redirect('/functionals')->with('info','New Function has been created!');
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
        $functional = Functional::find($id);
        return view('sys_mg.functionals.edit')->with('functional',$functional);
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
            'function_name' => 'required|min:3|unique:functionals'
        ]);
        $functional = Functional::find($id);
        $functional->function_name = $request->input('function_name');
        $functional->save();
        return redirect('/functionals')->with('info','Selected Function has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $functional = Functional::find($id);
        $functional->delete();
        return redirect('/functionals')->with('info','Selected Function has been deleted!');
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
        $functionals = Functional::where( 'function_name' , 'LIKE' , '%'.$str.'%' )
            ->orderBy('function_name','asc')
            ->paginate(15);
        return view('sys_mg.functionals.index')->with([ 'functionals' => $functionals ,'search' => true ]);
    }
}
