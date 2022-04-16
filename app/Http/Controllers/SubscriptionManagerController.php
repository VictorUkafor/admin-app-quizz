<?php

namespace App\Http\Controllers;

use Auth, Validator, Log, Session;
use Illuminate\Http\Request;
use App\Models\SubscriptionPackageModel;

class SubscriptionManagerController extends Controller
{
    public function index(){
        $packages = SubscriptionPackageModel::all();
        $data = [
            'packages' => $packages,
            "page" => "subs"
        ];
        return view('Subscription.index', $data);
    }

    public function addPackage(Request $request){
        try{
            $validator =  Validator::make($request->all(), $this->storeRules());
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $newPackage = new SubscriptionPackageModel;
            $newPackage->package_name = $request->package_name;
            $newPackage->package_query = $request->package_query;
            $newPackage->package_type = $request->package_type;
            $newPackage->package_payment_type = $request->package_payment_type;
            $newPackage->is_active = ($request->package_dormancy == "1") ? true : false;
            $newPackage->save();

            $message = "Package Added";
            return $this->displaySuccessMessage($message);


        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function editPackage(Request $request){
        try{
            if(!$request->package_id){
                $message = "Package Not found.";
                return $this->displayErrorMessage($message);
            }

            $editRules = $this->editRules($request->package_id);

            $validator =  Validator::make($request->all(), $editRules);
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $package = SubscriptionPackageModel::where('id', $request->package_id)->first();
            if($package){
                $package->package_name = $request->package_name;
                $package->package_query = trim($request->package_query);
                $package->package_type = $request->package_type;
                $package->package_payment_type = $request->package_payment_type;
                $package->is_active = ($request->package_dormancy == "1") ? true : false;
                $package->save();

                $message = "Package Updated";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "Package Not found.";
                return $this->displayErrorMessage($message);
            }

        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function deletePackage($packageId){

        if(!$packageId){
                $message = "Package Not found.";
                return $this->displayErrorMessage($message);
        }

        try{
            $package = SubscriptionPackageModel::where('id', $packageId)->first();
            if($package){
                $package->delete();
                $message = "Package Deleted.";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "Package Not found.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    private function storeRules(){

        $rules = [
            'package_name'=>'required',
            'package_query'=>'required|unique:subscription_packages',
            'package_type'=>'required',
            'package_payment_type'=>'required',
            'package_dormancy'=>'required',
        ];

        return $rules;
    }

    private function editRules($packageId){
        $rules = [
            'package_name'=>'required',
            'package_query'=>'required|unique:subscription_packages,package_query,'.$packageId,
            'package_type'=>'required',
            'package_payment_type'=>'required',
            'package_dormancy'=>'required',
            'package_id' => 'required'
        ];

        return $rules;
    }

    private function handleError($error){
        Log::info($error->getMessage());
        $message = "Error in connection please try again";
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
