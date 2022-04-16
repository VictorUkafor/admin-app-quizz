<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionPackageModel;

use Auth, Validator, Log, Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function subscriptions(){
        try{
            $packages = SubscriptionPackageModel::all();
            $user = User::where('id', Auth::id())->first();
            if($user){

                $userSub = $user->subscription;
                $subs = [];
                if($userSub){
                    $package = SubscriptionPackageModel::where('package_query', $userSub->type)->first();
                    if($package){
                        $subs[] = [
                            'query' => $userSub->type,
                            'start_date' => date("Y-m-d", $userSub->start_date),
                            'end_date' => date("Y-m-d", $userSub->end_date),
                            "is_active" => $userSub->is_active,
                            'package_name' => $package->package_name,
                            'package_id' => $package->id
                        ];
                    }


                    if(($userSub->addons != null) && count($userSub->addons) > 0){
                        foreach($userSub->addons as $addon){
                            if(isset($addon['query'])){
                                $package = SubscriptionPackageModel::where('package_query', $addon['query'])->first();
                                if($package){
                                    $subs[] = [
                                        'query' => $addon['query'],
                                        'start_date' => date("Y-m-d", $addon['start']),
                                        'end_date' => date("Y-m-d", $addon['end']),
                                        'payment_type' => $addon['payment_type'],
                                        "is_active" => $addon['is_active'],
                                        'package_name' => $package->package_name,
                                        'package_id' => $package->id
                                    ];
                                }
                            }
                        }
                    }

                }

                $data = [
                    'user' => $user,
                    'subs' => $subs,
                    'packages' => $packages,
                    'page' => 'subs'
                ];

                return view('User.subscription', $data);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }


        }catch (Exception $error) {
            return $this->handleError($error);
        }
    }


    public function settings(){

        try{
            $data = [
                'page' => 'settings'
            ];
            return view('User.settings', $data);
        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }



    public function editPassword(Request $request){
        try{
            $validator =  Validator::make($request->all(), $this->passwordRules());
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = User::where('id', $request->user_id)->first();
            if($user){
                $user->password = bcrypt($request->password);
                $user->save();

                $message = "User Updated";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }



            return $request->all();
        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function updateSettings(Request $request){
        try{
            if(!$request->user_id){
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }

            $editRules = $this->settingRules($request->user_id);

            $validator =  Validator::make($request->all(), $editRules);
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::where('id', $request->user_id)->first();
            if($user){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile = $request->mobile;
                $user->save();

                $message = "User Updated";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }

        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    private function settingRules($userId){
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$userId,
            'user_id' => 'required'
        ];

        return $rules;
    }

    private function passwordRules(){

        $rules = [
            'user_id'=>'required',
            'password' => 'required|string|min:6|same:confirm_password'
        ];

        return $rules;
    }



    private function handleError($error){
        Log::info($error->getMessage());
        $message = "Unable to complete request. Please try again";
        Session::put("errorMessage", $message);
        return redirect()->back();
    }

    private function displayErrorMessage($message){
        Session::put("errorMessage", $message);
        return redirect()->back();
    }

    private function displaySuccessMessage($message){
        Session::put("successMessage", $message);
        return redirect()->back();
    }

}
