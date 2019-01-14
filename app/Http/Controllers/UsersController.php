<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TblUsersProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
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
         *  It works the same as employeescontroller
         *  please see the comments for explaination
         *  on what's going on here.
         */
        
        $users = User::Paginate(15);
        return view('user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tbl_users_profile = TblUsersProfile::all();
        return view('user.create')
            ->with([
                'tbl_users_profile'    =>  $tbl_users_profile
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
        $user = new User();
        $this->validateRequest($request,NULL);
        $fileNameToStore = $this->handleImageUpload($request);
        $this->setUser($request ,$user, $fileNameToStore);
        return redirect('/users')->with('info','New user has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $tbl_users_profile = TblUsersProfile::all();
        return view('user.edit')
            ->with([
                'user' => $user,
                'tbl_users_profile'    =>  $tbl_users_profile
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
        
        $user = User::find($id);
        
        if($request->hasFile('picture')){

            $fileNameToStore = $this->handleImageUpload($request);
            Storage::delete('public/users/'.$user->picture);
        }else{
            $fileNameToStore = '';
        }
        
        $this->setUser($request, $user ,$fileNameToStore);
        return redirect('/user')->with('info','selected user has been updated');
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
         *  Check if the user is not the
         *  current authenticated user
         */
        if($id == Auth::user()->id){
            //redirect to users route
            return redirect('/users')->with('info','Authenticated user cannot be deleted!');
        }
        
        $user = User::find($id);

        //delete the user picture
        Storage::delete('public/users/'.$user->picture);
        $user->delete();
        return redirect('/users')->with('info','selected user has been deleted!');
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
        $users = User::where( $option , 'LIKE' , '%'.$str.'%' )
            ->orderBy($option,'asc')
            ->paginate(4);
        return view('user.index')->with([ 'users' => $users ,'search' => true ]);
    }

    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
            'first_name'   =>  'required|min:1',
            'last_name'    =>  'required|min:1',
            'user_type'    =>  'required|min:1',
            //if we are updating user but not changing password.
            'password'     =>  ''.( $id ? 'nullable|min:3' : 'required|min:3' ),
            'username'     =>  'required|unique:users,username,'.($id ? : '' ).'|min:3',
            'email'        =>  'required|email|unique:users,email,'.($id ? : '' ).'|min:7',
            'picture'      =>  ''.($request->hasFile('picture')  ? 'required|image|max:1999' : '')
        ]);
    }

    /**
     * Add or update an user
     */
    private function setUser(Request $request , User $user , $fileNameToStore){
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->user_type = $request->input('user_type');
        $user->email = $request->input('email');
        if($request->input('password') != NULL){
            $user->password = $request->input('password');
        }
        if($request->hasFile('picture')){
            $user->picture = $fileNameToStore;
        }
        $user->save();
    }

    /**
     *  Handle Image Upload
     */
    public function handleImageUpload(Request $request){
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
            $path = $request->file('picture')->storeAs('public/users' , $fileNameToStore);
        }
        /**
         *  return the file name so we can add it to database.
         */
        return $fileNameToStore;
    }
}
