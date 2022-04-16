<?php
namespace App\Helpers;

use App\Helpers\Config;
use App\Helpers\Helper;
use App\Events\UserCreatedEvent;
use App\Events\UserSubscriptionUpdatedEvent;
use App\Models\SubscriptionPackageModel;
use App\Helpers\MailManager;
use App\Helpers\PaymentTransactionLogger;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Models\Subscription;

use Auth;

class SubscriptionManager {

	public static function today()
	{
		return strtotime("now");
	}

	public static function months($n)
	{
		return $n === 1 ? strtotime("+$n month") : strtotime("+$n months");
	}

	public static function oneMonth()
	{
		return strtotime("+1 month");
	}

	public static function oneYear()
	{
		return strtotime("+1 year");
    }

    public static function hundredYears()
	{
		return strtotime("+100 years");
	}

	public static function addUser($sub_data, $type)
	{
		$user = User::firstOrNew(['email' => $sub_data['email']]);

		if ($user->id)
		{
			$user->new = false;

			return $user;
		}
		else
		{
			$plain_password = !empty($sub_data['password']) ? $sub_data['password'] : Helper::randomPassword();

			$user->name = $sub_data['firstname'] . ' ' . $sub_data['lastname'];
			$user->email = $sub_data['email'];
            $user->password = bcrypt($plain_password);
            $user->is_active = true;
            $user->user_type = Helper::REGULAR_USER;

            $user->save();

            $user->plain_password = $plain_password;
			$user->new = true;

            event(new UserCreatedEvent($user));


			return $user;
		}
	}

	public static function addFrontEndSubscription(
        $sub_data, $start, $end,
        $type = '', $log_txn = true,$extra_subs = []
    )
	{
		$user = SubscriptionManager::addUser(array_merge($sub_data, ['type' => $type]), $type);

		$sub = Subscription::firstOrNew(['user_id' => $user->id]);

		if (!$sub->created_at)
		{
			$sub->start_date = $start;
            $sub->end_date = $end;
            $sub->is_active = true;

			$sub->type = $type;

			foreach ($extra_subs as $key => $value)
			{
				$sub->{$key} = $value;
			}

			$sub->save();

            MailManager::sendSubscriptionEmail($user,$type,$end);
		}
		else
		{
            $sub_array = $extra_subs;

			if ( !empty($start) && !empty($end) )
				$sub_array = array_merge([
					'start_date' => $start,
					'end_date' => $end,
                    'type' => $type,
                    'is_active' => true
				], $extra_subs);

			Subscription::where('user_id', $user->id)->update($sub_array);

            MailManager::sendSubscriptionExtendedEmail($user,$type,$end);
		}

        self::logPaymentTransaction($sub_data, $type);

        event(new UserSubscriptionUpdatedEvent($user, $sub));


		return $user;
	}

	public static function processFrontEndRefund($sub_data, $sub_type, $log_txn = true)
	{
		$user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
            $sub = $user->subscription;

			if ($sub && $sub->type === $sub_type)
			{
				Subscription::where('user_id', $user->id)->update([
                    'end_date' => strtotime('now'),
                    'is_active' => false
                ]);

                MailManager::sendSubscriptionCancelledEmail($user);

                event(new UserSubscriptionUpdatedEvent($user, $sub));

            
			}
		}
		self::logPaymentTransaction($sub_data, $sub_type);
    }

    public static function addAddonSubscription($sub_data, $duration, $sub_type, $payment_type)
	{
        $user = User::where(['email' => $sub_data['email']])->first();

		if ($user)
		{
			$sub = $user->subscription;

			if ($sub)
			{

                $addons = $sub->addons;

                if(!isset($addons[$sub_type])){
                    $addons[$sub_type] = [
                        'query' => $sub_type,
                        'start' => $duration['start'],
                        'end' => $duration['end'],
                        'payment_type' => $payment_type,
                        'is_active' => true

                    ];
                }else{
                    $addons[$sub_type]['start'] = $duration['start'];
                    $addons[$sub_type]['end'] = $duration['end'];
                    $addons[$sub_type]['is_active'] = true;
                }

                $currentSub = Subscription::where('user_id', $user->id)->first();
                $currentSub->addons = $addons;
                $currentSub->save();

                MailManager::sendAddonSubscriptionEmail($user,$sub_type);

                event(new UserSubscriptionUpdatedEvent($user, $currentSub));

                
			}
		}
		self::logPaymentTransaction($sub_data, $sub_type);

        return true;
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

	public static function cancelMainSubscription($user)
	{
        $user->subscription_is_active = false;
        $user->save();
	}

   	public static function resumeMainSubscription(User $user)
   	{
        $user->subscription_is_active = true;
        $user->save();
   	}

   	public static function logPaymentTransaction($sub_data, $sub_type)
   	{
   		PaymentTransactionLogger::log(
   			$sub_data['fullname'],
   			$sub_data['email'],
   			$sub_data['payment_gateway'],
   			$sub_data['amount'],
   			$sub_data['payment_status'],
   			$sub_data['txn_id'],
   			$sub_type,
   			$sub_data['order_id']
   		);
   	}

  
    public static function HandleSubscriptionRequest($query, $sub_data){

        $package = SubscriptionPackageModel::where('package_query', $query)->first();
        if($package){
            if($package->package_type == 'frontend'){
                $duration = self::setDuration($package);
                self::addFrontEndSubscription($sub_data, $duration['start'], $duration['end'], $query);
            }else{
                $duration = self::setDuration($package);
                self::addAddonSubscription($sub_data, $duration, $query, $package->package_payment_type);
            }
            self::logPaymentTransaction($sub_data, $query);
        }else{
            self::logPaymentTransaction($sub_data, $query);
        }
    }

    public static function HandleRefundRequest($query, $sub_data){
        $package = SubscriptionPackageModel::where('package_query', $query)->first();
        if($package){
            if($package->package_type == 'frontend'){
                self::processFrontEndRefund($sub_data, $query);
            }else{
                self::processAddonRefund($sub_data, $query, $package->package_payment_type);
            }
            self::logPaymentTransaction($sub_data, $query);
        }else{
            self::logPaymentTransaction($sub_data, $query);
        }

    }

    public static function setDuration($package){
        $duration = [];
        if($package->package_payment_type == "onetime"){
            $duration['start'] = self::today();
            $duration['end'] = self::hundredYears();
        }elseif($package->package_payment_type == "monthly"){
            $duration['start'] = self::today();
            $duration['end'] = self::oneMonth();
        }elseif($package->package_payment_type == "yearly"){
            $duration['start'] = self::today();
            $duration['end'] = self::oneYear();
        }

        return $duration;
    }
}
