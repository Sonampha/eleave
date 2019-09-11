<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
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
        
        $users = User::Paginate(20);
        return view('user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_types = UserType::all();
        return view('user.create')
            ->with([
                'user_types'    =>  $user_types
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
        $user_types = UserType::all();
        return view('user.edit')
            ->with([
                'user' => $user,
                'user_types'    =>  $user_types
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
            Storage::delete(public_path().'uploads/users/'.$user->picture);
            $fileNameToStore = $this->handleImageUpload($request);     
        }else{
            if($id){
                $fileNameToStore = $user->picture;
            }else{
                $fileNameToStore = '';
            }
            
        }
        
        $this->setUser($request, $user ,$fileNameToStore);

        if($user->username == Auth::user()->username){
            return redirect('/user')->with('info','selected user has been updated');
        }else{
            return redirect()->back()->with('info','selected user has been updated');
        }
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
        Storage::delete('uploads/users/'.$user->picture);
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
            ->paginate(20);
        return view('user.index')->with([ 'users' => $users ,'search' => true ]);
    }

    /**
     *  Validate all the inputs
     */
    private function validateRequest(Request $request, $id)
    {
        $this->validate($request,[
			'full_name'    =>  'required|min:1',
            //if we are updating user but not changing password.
            'password'     =>  ''.( $id ? 'nullable|min:3' : 'required|min:3' ),
            'staff_id'     =>  'required|unique:users,username,'.($id ? : '' ).'|min:3',
            'email'        =>  'required|email',
            'picture'      =>  ''.($request->hasFile('picture')  ? 'required|image|max:1999' : '')
        ]);
    }

    /**
     * Add or update an user
     */
    private function setUser(Request $request , User $user , $fileNameToStore){
        $user->full_name = $request->input('full_name');
        $user->username = $request->input('staff_id');
        if(Auth::user()->user_type == 'ADMIN'){
            $user->user_type = $request->input('user_type');
        }        
        $user->email = $request->input('email');
        if($request->input('password') != NULL){
            $user->password = $request->input('password');
        }
        if($fileNameToStore != ''){
            $user->picture = $fileNameToStore;
        }else{
            $user->picture = 'user.png';
        }

        $user->save();
    }

    /**
     *  Handle Image Upload
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
            $path = $request->file('picture')->storeAs('users', $fileNameToStore, 'public_uploads');
        }
        /**
         *  return the file name so we can add it to database.
         */
        return $fileNameToStore;
    }
}
