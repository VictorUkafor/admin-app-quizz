<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Session, Log, Mail, Auth, Validator;
use App\Mail\PasswordRecoveryMail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function passwordReset(){
        return view('Auth.password-recovery');
    }

    public function emailVerification($token){
        try{

            if($token){
                $user = User::where('user_token', $token)->first();

                if($user){
                    $data = ['user_token' => $token];
                    return view('Auth.change-password', $data);

                }else{
                    $message = "Sorry we were unable to complete this action";
                    Session::put('errorMessage', $message);

                    return redirect()->route('auth.password.reset');
                }

            }else{
                $message = "Sorry we were unable to complete this action";
                Session::put('errorMessage', $message);

                return redirect()->route('auth.password.reset');
            }

        }catch(\Exception $error){
            Log::info($error->getMessage());
            Session::put('errorMessage', 'Unable to complete request.');
            return redirect()->route('auth.password.reset');
        }
    }

    public function recoverPassword(Request $request){
        try{
            if($request->email){
                $user = User::where('email', $request->email)->first();

                if($user){

                    $user->user_token = str_random(50);
                    $user->save();

                    Mail::to($request->input('email'))
                    ->send(new PasswordRecoveryMail($user));

                    $message = "We have sent you a mail, please go through it to complete this process";
                    Session::put('successMessage', $message);
                    return redirect()->back();

                }else{
                    $message = "Sorry, this email wasn't found in our records.";
                    Session::put('errorMessage', $message);

                    return redirect()->back();
                }

            }else{
                $message = "Your email is required to complete this action";
                Session::put('errorMessage', $message);

                return redirect()->back();
            }

        }catch(\Exception $error){
            Log::info($error->getMessage());
            Session::put('errorMessage', 'Unable to complete request.');
            return redirect()->route('login');
        }
    }

    public function resetPassword(Request $request){
        try{

            $validator = $this->passwordValidator($request->all());

            if(!$validator->fails()){

                $user = User::where('user_token', $request->user_token)->first();

                if($user){
                    $user->user_token = "";
                    $user->password = bcrypt($request->password);
                    $user->save();

                    return redirect()->route('login');


                }else{
                    $message = "Sorry, we couldn't find your details in our records.";
                    Session::put('errorMessage', $message);

                    return redirect()->route('login');
                }

            }else{
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();

            }

        }catch(\Exception $error){
            Log::info($error->getMessage());
            Session::put('errorMessage', 'Unable to complete request.');
            return redirect()->route('login');
        }
    }

    private function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
            'user_token' => 'required'
        ]);
    }
}
