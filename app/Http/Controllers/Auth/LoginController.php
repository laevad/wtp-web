<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
//    protected string $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo(){
        if(auth('web')->user()->role_id==User::ROLE_ADMIN){
            return route('admin.dashboard');
        }
        if(auth('web')->user()->role_id==User::ROLE_USER){
            return route('user.dashboard');
        }
        if(auth('web')->user()->role_id==User::ROLE_CLIENT){
            return route('client.dashboard');
        }
        return redirect()->route('login');
    }

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
        $input = $request->all();
        $this->validate($request,[
            'email' => 'required|email',
            'password'=>'required',
        ]);

        if (auth('web')->attempt(array('email'=>$input['email'], 'password'=>$input['password'] ))){
            if (auth('web')->user()->role_id == User::ROLE_ADMIN){
                return redirect()->route('admin.dashboard');
            }
            if (auth('web')->user()->role_id == User::ROLE_USER){
                return redirect()->route('user.dashboard');
            }
            if (auth('web')->user()->role_id == User::ROLE_CLIENT){
                return redirect()->route('client.dashboard');
            }
        }
        return redirect()->back()->withInput($request->input())->withErrors(['email'=>'These credentials do not match our records.']);
    }
}
