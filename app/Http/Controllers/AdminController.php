<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Helpers\EventHelper;
use App\Models\Subscription;
use App\Models\WebhookModel;
use App\Models\PaymentTransactionLog;
use Illuminate\Http\Request;
use App\Events\UserCreatedEvent;
use App\Events\UserUpdatedEvent;
use App\Events\UserSubscriptionUpdatedEvent;
use App\Helpers\MailManager;
use App\Models\SubscriptionPackageModel;

use Auth, Validator, Log, Session;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');

    }

    public function index(Request $request){
        
        try{

            $users = User::take(5);

            $sumOfUsers = count(User::all());
            $sumOfUsersToday = count(User::whereDay('created_at', now()->day)->get());
            $sumOfUsersThisWeek = count(User::whereBetween('created_at',[
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->get());


            $data = [
                'users'=>$users,
                'sumOfUsers' => $sumOfUsers,
                'sumOfUsersToday' => $sumOfUsersToday,
                'sumOfUsersThisWeek' => $sumOfUsersThisWeek,
                'sumOfWidgets' => null,
                "page" => "dashboard"
            ];
            return view('Admin.index', $data);
        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function transactions(){
        $transactions = PaymentTransactionLog::all();
        $data = [
            'transactions' => $transactions,
            "page" => "transactions"
        ];
        return view('Transactions.index', $data);
    }

    public function users(){
        try{
            $users = User::get();
            $data = [
                'users' => $users,
                "page" => "users"
            ];

            return view('Admin.users', $data);
        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function subscriptions($userId){
        try{
            $packages = SubscriptionPackageModel::all();
            $user = User::where('id', $userId)->first();
            if($user){

                $userSub = $user->subscription;

                $subs = [];
                if($userSub){
                    $package = SubscriptionPackageModel::where('package_query', $userSub->type)->first();
                    if($package){
                        $subs[] = [
                            'query' => $userSub->type,
                            'user_id' => $userId,
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
                                        'user_id' => $userId,
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
                    "page" => "users"
                ];

                return view('Admin.user-subs', $data);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }


        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function addSubscriptions(Request $request){
        try{


            $validator =  Validator::make($request->all(), $this->subStoreRules());
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $package = SubscriptionPackageModel::where('id', $request->subscription_package)->first();
            $user = User::where('id', $request->user_id)->first();
            if($package && $user){


                if($package->package_type == 'frontend'){
                    $response = $this->addFrontEndSubscription($user, $package, $request);
                }else{
                    $response = $this->addAddonSubscription($user, $package, $request);
                }

                if($response['status'] == true){
                    return $this->displaySuccessMessage($response['message']);
                }else{
                    return $this->displayErrorMessage($response['message']);
                }

            }else{
                $message = "User or Package Not found.";
                return $this->displayErrorMessage($message);
            }

        }catch (Exception $error) {
            return $this->handleError($error);
        }
    }

    public function deleteSubscription($userId,$queryId){
      
        if(!$userId && !$queryId){
            $message = "Subscription Not found.";
            return $this->displayErrorMessage($message);
        }

        try{
            $user = User::where('id', $userId)->first();
            if($user){
                $feedback = $this->cancelSubscription($user,$queryId);
                if ($feedback) {
                    $message = "Subscription Deleted.";
                    return $this->displaySuccessMessage($message);
                }else{
                    $message = "Subscription Not Deleted.";
                    return $this->displayErrorMessage($message);
                }
            }else{
                $message = "Subscription Not found.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    public function addUser(Request $request){

        try{
            $validator =  Validator::make($request->all(), $this->storeRules());
            if($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->mobile = $request->mobile;
            //$newUser->sub_users_quota = $request->quota;
            $newUser->user_type = $request->user_type;
            $newUser->is_active = ($request->is_active == "1") ? true : false;
            $newUser->password = bcrypt($request->password);
            $newUser->save();

            $message = "User Added";

            MailManager::sendWelcomeMail($newUser);

            event(new UserCreatedEvent($newUser));

            return $this->displaySuccessMessage($message);

        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function editUser(Request $request){
        try{

            // return $request->all();
            if(!$request->user_id){
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }

            $editRules = $this->editRules($request->user_id);

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
                //$user->sub_users_quota = $request->quota;
                $user->user_type = $request->user_type;
                $user->is_active = ($request->is_active == "1") ? true : false;
                $user->save();

                $message = "User Updated";
                event(new UserUpdatedEvent($user));

                return $this->displaySuccessMessage($message);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }

        }catch (\Exception $error) {
            return $this->handleError($error);
        }
    }

    public function deleteUser($userId){

        if(!$userId){
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
        }

        try{
            $user = User::where('id', $userId)->first();
            if($user){
                $user->delete();
                $message = "User Deleted.";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "User Not found.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
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
                event(new UserUpdatedEvent($user));

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

    public function webhooks(){
        try{
            $events = EventHelper::EVENTS;
            $webhooks = WebhookModel::all();

            $data = [
                'events' => $events,
                'webhooks' => $webhooks,
                "page" => "webhooks"
            ];

            return view('Admin.webhooks', $data);
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    public function addWebhook(Request $request){
        try{

            $events = EventHelper::EVENTS;
            $selectedEvent = collect($events)->where('event', $request->event)->first();

            if($selectedEvent && $request->webhook_url){

                $webhook = new WebhookModel;
                $webhook->event = $selectedEvent["event"];
                $webhook->webhook_url = $request->webhook_url;
                $webhook->save();


                $message = "Webhook added.";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "A valid event and URL is required to complete this request.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    public function updateWebhook(Request $request){
        try{

            $events = EventHelper::EVENTS;
            $selectedEvent = collect($events)->where('event', $request->event)->first();
            $webhook = WebhookModel::where('id', $request->webhook_id)->first();

            if($selectedEvent && $request->webhook_url  && $webhook){

                $webhook->event = $selectedEvent["event"];
                $webhook->webhook_url = $request->webhook_url;
                $webhook->save();


                $message = "Webhook Updated.";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "A valid event, selected webhook and URL is required to complete this request.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    public function deleteWebhook($webhookId){
        try{
            $webhook = WebhookModel::where('id', $webhookId)->first();
            if($webhook){
                $webhook->delete();
                $message = "Webhook Deleted.";
                return $this->displaySuccessMessage($message);
            }else{
                $message = "Webhook Not found.";
                return $this->displayErrorMessage($message);
            }
        }catch(\Exception $error){
            return $this->handleError($error);
        }
    }

    private function storeRules(){

        $rules = [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'user_type'=>'required',
            'is_active'=>'required',
            'password' => 'required|string|min:6|same:confirm_password'
        ];

        return $rules;
    }

    private function editRules($userId){
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$userId,
            'user_type'=>'required',
            'is_active'=>'required',
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

    private function subStoreRules(){

        $rules = [
            'subscription_package'=>'required',
            'user_id'=>'required',
            'start_date'=>'required',
            'status'=>'required',
            'end_date' => 'required'
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

    private function addFrontEndSubscription($user, $package, $request){

        $sub = Subscription::firstOrNew(['user_id' => $user->id]);
        $duration['start'] = strtotime($request->start_date);
        $duration['end'] = strtotime($request->end_date);


        $sub->start_date = $duration['start'];
        $sub->end_date = $duration['end'];
        $sub->is_active = ($request->status)? true : false;

        $sub->type = $package->package_query;
        $sub->save();

        event(new UserSubscriptionUpdatedEvent($user, $sub));

        $response['status'] = true;
        $response['message'] = "Subscription updated";
        return $response;
    }

    private function addAddonSubscription($user, $package, $request){

        $response = [];
        $sub = $user->subscription;
        $duration['start'] = strtotime($request->start_date);
        $duration['end'] = strtotime($request->end_date);

        if ($sub)
        {

            $addons = $sub->addons;


            if(!isset($addons[$package->package_query])){
                $addons[$package->package_query] = [
                    'query' => $package->package_query,
                    'start' => $duration['start'],
                    'end' => $duration['end'],
                    'payment_type' => $package->package_payment_type,
                    'is_active' => ($request->status)? true : false

                ];
            }else{
                $addons[$package->package_query]['start'] = $duration['start'];
                $addons[$package->package_query]['end'] = $duration['end'];
                $addons[$package->package_query]['is_active'] = ($request->status)? true : false;
            }

            $currentSub = Subscription::where('user_id', $user->id)->first();
            $currentSub->addons = $addons;
            $currentSub->save();

            event(new UserSubscriptionUpdatedEvent($user, $currentSub));


            $response['status'] = true;
            $response['message'] = "Subscription updated";
            return $response;
        }


        $response['status'] = false;
        $response['message'] = "Unable to update user's subscription. Please make sure the user has a front end subscription";
        return $response;
    }

    public static function cancelSubscription($user, $query)
    {
        $sub = Subscription::where('user_id',$user->id)->first();

        if ($sub)
        {
            if ($sub->type === $query)
            {
                $payload = $sub->delete();
                if ($payload) {

                    event(new UserSubscriptionUpdatedEvent($user, $sub));

                    return true;
                }
            }else{
                $addons = $sub->addons;
                if(isset($addons[$query])){
                    unset($addons[$query]);
                }
                $sub->addons = $addons;
                $payload = $sub->save();
                if ($payload) {

                    event(new UserSubscriptionUpdatedEvent($user, $sub));

                    return true;
                }
            }
        }

        return false;
    }

    public static function processAddonRefund($sub_data, $sub_type, $payment_type)
    {
        $user = User::where(['email' => $sub_data['email']])->first();

        if ($user)
        {
            $sub = $user->subscription;

            if ($sub)
            {

                $addons = $sub->addons;

                if(isset($addons[$sub_type])){
                    $addons[$sub_type] = [
                        'query' => $sub_type,
                        'start' => self::today(),
                        'end' => self::today(),
                        'payment_type' => $payment_type,
                        'is_active' => false

                    ];
                }

                $currentSub = Subscription::where('user_id', $user->id)->first();
                $currentSub->addons = $addons;
                $currentSub->save();

                MailManager::sendAddonSubscriptionCancelledEmail($data,$sub_type);

                event(new UserSubscriptionUpdatedEvent($user, $currentSub));
                
            }
        }

        self::logPaymentTransaction($sub_data, $sub_type);

        return true;
    }

    public function settings(){
        try{
            $data = [
                "page" => "settings"
            ];
            return view('Admin.settings', $data);
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
                event(new UserUpdatedEvent($user));

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


}
