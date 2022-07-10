<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Cookie, Config;
use Davmixcool\Cryptman;
use Session;

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

    // protected function authenticated(Request $request, $user)
    // {
    //     if ($user->user_type == 'admin' || $user->is_active == true ){
    //         return redirect()->route('admin.dashboard');
    //     }

    //     return $this->logout();
    // }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginView(){
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        //dd($this->attemptLogin($request));
        if ($this->attemptLogin($request)) {
            //Cache::store('memcached')->put('user', Auth::user(), 60 * 60 * 2);

            if(Auth::user()->user_type == 'admin'){
               return redirect()->route('admin.dashboard');

            }else{
                Auth::logout();
                Session::put('errorMessage', 'You are not authorized proceed.');
                return redirect('/login');
            }


        }else{
            Session::put('errorMessage', 'Wrong email or password');
            return redirect('/login');
        }
    }

    public function logout(){
        Auth::logout();
        //Cache::store('memcached')->forget('user');
        return redirect('/login');
    }
}
