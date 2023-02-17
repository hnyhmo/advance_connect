<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $userCheck = User::select("users.*", "user_passwords.password as pwd")
                    ->leftJoin('user_passwords', function($join) {
                        $join->on('users.id', '=', 'user_passwords.user_id');
                    })
                    ->where('users.email', $request->email)
                    ->where('users.status', 1)
                    // ->where('users.type', 'admin')
                    ->orderBy('user_passwords.created_at', 'desc')
                    ->first();
                    
        if($userCheck){
            if(\Hash::check($request->password, $userCheck->pwd)){
	                \Auth::login($userCheck);
	                return redirect()->intended(route('login'));

            }  else {
                $this->incrementLoginAttempts($request);
                return redirect(route('login'))
                    ->withErrors(['message' => 'The credentials do not match our records'])
                    ->withInput();
            }
        }else{            
            $this->incrementLoginAttempts($request);
            return redirect(route('login'))
                ->withErrors(['message' => 'The credentials do not match our records'])
                ->withInput();
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);

    }

    public function verify_code(Request $request)
    {
        $success = false;
        $user = null;
        if($request->session()->has('user_data') AND $request->code){
            $u = $request->session()->get('user_data');
            $user = User::where('id', $u->id)->first();

            $hourdiff = 1 - round((strtotime(date('Y-m-d H:i:s')) - strtotime($user->date_blocked))/3600, 1);
            
            if($user->code_try >= 3 AND $user->blocked AND $hourdiff > 0){
                return redirect(route('login'))
                ->withErrors(['message' => 'Your account is temporary locked, please wait for '.$hourdiff.'hr & try again.'])
                ->withInput();   
            }
            else if($user->temp_code == $request->code){
                $success = true;
            }else{
                $blocked = ($user->code_try >= 2)?1:0;
                User::where('id', $user->id)->update(['blocked' => $blocked, 'code_try' => \DB::raw('code_try+1'), 'date_blocked'=>date('Y-m-d H:i:s')]);
            }
        }

        if($success){
            User::where('id', $user->id)->update(['blocked' => 0, 'code_try' => 0]);
            \Auth::login($user);
            return redirect()->intended(route('login'));
        }else{
        
            return redirect('/')
                ->withErrors(['message' => 'Invalid verification code, please try again.'])
                ->withInput();    
        }
    }


    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
    }
}
