<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserResourseController extends BaseController
{
    public function __construct()
    {
     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users   = User::orderBy('id','desc')->orderBy('id',"desc")->get();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
      
        $user = Auth::user();
        return view('admin.user.profile',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function add()
    {
       
        return view('admin.user.create');
    }
    public function create(Request $request)
    {
        $request->validate([
                'name'      => 'required',
                'email'     => 'required|unique:users,email',
                'password'  => 'required|confirmed',
        ]);
        $attributes = $request->except(['password','password_confirmation','token']);
        $attributes['password'] = Hash::make($request->password);
        $user = User::create($attributes);

        if(@$user->id){
            return response()->json(['url' =>  url('/admin/users'),'message'=>'success']);
        }
        return null;
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
        $user       = User::find($id);
        return view('admin.user.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id=null)
    {
      
        $user       = Auth::user();
        $attributes = $request->all();
        $user->update($attributes);
        return redirect('admin/profile');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ]);
        $user       = User::find($id);
        $attributes = $request->all();
        $user->update($attributes);
        return redirect('admin/user/edit/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $order        = Order::where('user_id',$id)->count();

        if($order > 0){
            return response()->json(['status' =>  "falied",'message'=>"Can't delete user"]);
        }else{
            $user       = User::find($id);
            $user->delete();
            return response()->json(['status' =>  "success",'message'=>'user deleted successfully']);
        }

    }
}
