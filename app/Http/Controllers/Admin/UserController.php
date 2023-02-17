<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPassword;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Users';
        $users = User::orderBy('name', 'asc')->where([
            ['email', '!=', 'api@smc.com'],
            [function($query) use ($request){
                if($request->name)
                    $query->where('name', 'LIKE', '%'.$request->name.'%');
                if($request->email)
                    $query->where('email', 'LIKE', '%'.$request->email.'%');
                if($request->has('status') && !is_null($request->status)){
                    $stat = ($request->status)?$request->status:0;
                    $query->where('status', $stat);
                }
            
            }]
        ]);
        
        $data['users'] = $users->paginate(20)->appends($request->except(['page']));
        return view('dashboard.user.index', $data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Users - New';
        return view('dashboard.user.form', $data);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= ['msg' => "Something went wrong, please try again", 'success'=>false];
        $validator =  \Validator::make($request->all(),[
            'name'=>'required|max:255|min:2',
            'email'=>'required|email|max:255|min:5|unique:users,email',
            'password'=>'required|max:255|confirmed|min:6'
        ]);

        if ($validator->fails())
        {
            $errors = '';
            foreach ($validator->getMessageBag()->toArray() as $vv) {
                $errors .= $vv[0]."<br />";
            }
            $data['error'] = $errors;
        }else{

            $dd = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'status' => 1,
                'created_by_id' => auth()->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $d = User::create($dd);

            $pass_data = [
                'user_id' => $d->id,
                'password' => \Hash::make($request->password),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $upass = UserPassword::create($pass_data);

            if($upass){
                $emailData=[
                    'to' => $request->email, 
                    'name' =>$request->name, 
                    'subject' => env('APP_NAME')." CMS User", 
                    'msg' => "<p>Hi <b>".$request->name."</b>,</p>
                    <p>".auth()->user()->name." created you an account to access the ".env('APP_NAME')." dashboard.</p>
                    <p>Please use your email and this password to login: <b style='font-size: 16px'>".$request->password."</b></p>".
                            "<br><p><img src='".url()->to('img/smc-logo-wide.png')."' alt='".env('APP_NAME')."' width='150px'/></p>"
                ];
                sendEmail((object) $emailData);
            }

            // Log
            logThis(['type'=>'User', 'action'=>'ADD', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was added successfully.']);

            $data= ['msg' => "Item was added successfully", 'user'=>$d, 'success'=>true];
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d = User::findOrFail($id);
        $data['title'] = 'Users - '.$d->name;
        $data['d'] = $d;
        return view('dashboard.user.form', $data);   
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
        $data= ['msg' => "Something went wrong, please try again", 'success'=>false];

        $conditions = [
            'name'=>'required|max:255|min:2',
            'email'=>'required|email|max:255|min:5|unique:users,email,'.$id
        ];

        if($request->password){
            $conditions['password'] = 'required|max:255|confirmed|min:6';
        }

        $validator =  \Validator::make($request->all(), $conditions);

        $d = User::find($id);
        if(!$d){            
            $data['error'] = "Item not found";
        }
        else if ($validator->fails())
        {
            $errors = '';
            foreach ($validator->getMessageBag()->toArray() as $vv) {
                $errors .= $vv[0]."<br />";
            }
            $data['error'] = $errors;
        }
        else{

            $dd = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'status' => 1,
                'updated_by_id' => auth()->user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $d->update($dd);

            if($request->password){
                
                $pass_data = [
                    'user_id' => $d->id,
                    'password' => \Hash::make($request->password),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $upass = UserPassword::create($pass_data);
            }

            // Log
            logThis(['type'=>'User', 'action'=>'Update', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was updated successfully.']);

            $data= ['msg' => "Item was added successfully", 'user'=>$d, 'success'=>true];
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::find($id);
        if($delete->delete()){
            \DB::table('users')->where('id', $delete->id)->update(['deleted_by_id' => auth()->user()->id]);
            $d = \DB::table('users')->where('id', $delete->id)->first();
            // Log
            logThis(['type'=>'Website', 'action'=>'DELETE', 'item'=>$d->title]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was deleted successfully.']);
        }else{            
            // Return Message
            Session::flash('message',['type'=>'danger', 'msg'=>'Something went wrong, please try gain.']);
        }

    }


    public function change_password(){

        $data['title'] = "Change Password";
        return view('dashboard.user.change_password', $data);
    }

    public function change_password_submit(Request $request)
    {
        $msg = "Something went wrong, please try again.";
        $type = 'error';
        
        if(\Auth::user()->id AND $request->get('password')){
            $currentPass = UserPassword::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->first();
            $allPass = UserPassword::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();

            if (\Hash::check($request->get('current_password'), $currentPass->password)) {
                $checkPass = '';
                foreach($allPass as $ap){
                    if(\Hash::check($request->get('password'), $ap->password)){
                        $checkPass = 'exist';
                    }
                }

                if($checkPass == ''){
                    $new_data['password'] = \Hash::make($request->get('password'));
                    $new_data['user_id'] = \Auth::user()->id;
                    UserPassword::create($new_data);
                    $msg = "Password updated.";
                    $type = 'success';

                    logThis(['type'=>'Change Password', 'action'=>'UPDATE', 'item'=>\Auth::user()->email]);
                    Session::flash('message',['type'=>'success', 'msg'=>'Updated']);
                }else{                    
                    $msg = "Password has been already used, please choose another.";
                    Session::flash('message',['type'=>'danger', 'msg'=>'Password has been already used, please choose another.']);
                }

            }else{
                $msg = "Wrong password, please try again.";
                Session::flash('message',['type'=>'danger', 'msg'=>'Wrong password, please try again.']);
            }
        }

        return back();
    }

}
