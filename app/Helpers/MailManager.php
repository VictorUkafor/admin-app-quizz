<?php
namespace App\Helpers;

use App\Notifications\MailNotifier;
use App\User;
use Auth;
use App\Helpers\SubscriptionConfig;
use App\Helpers\Utility;
use Config;

class MailManager {

    const SUPPORT_EMAIL = 'support@quizzapp.com';

   	public static function sendWelcomeMail($user)
   	{
		$loginUrl = config('app.main_url');
   		//Mailer uses parsedown
   	$data = [
     		    'subject' => 'Welcome To ' . config()->get('app.name'),
     		    'greeting' => 'You’re in, {name} Let’s get started.',
     		    'content' => [
                    "Thank you for purchasing ".config()->get('app.name'),
                     "You can reach out to support on: ".self::SUPPORT_EMAIL
     			],
   		    //'actionUrl' => $loginUrl,
   		    //'actionText' => 'Login Here',
   		    'thankYouMessage' => config()->get('app.name').' Team',
          'salutation' => config()->get('app.main_url')
   		];

   		$user->notify(new MailNotifier($data));
   	}

    public static function sendUserActivateMail($user)
    {
      $data = [
          'subject' => 'Account Activated',
          'greeting' => 'Hello {name},',
          'content' => [
             'Your account has been activated. Login with the email and password you used during registration.'
        ],
        'thankYouMessage' => 'Thank you'
      ];

      $user->notify(new MailNotifier($data));
    }


    public static function sendBackupDatabaseMail($user)
    {
      $subject = 'Auto Backup Database';
      $message =  "Hurray, auto backup database was completed successfully";
      $data = [
          'subject' => $subject,
          'greeting' => 'Hello {name},',
          'content' => [
             $message
        ],
        'thankYouMessage' => 'Thank you'
      ];

      $user->notify(new MailNotifier($data));
    }



    public static function sendExportLeadsMail($user,$link)
    {
      $subject = 'Leads Exported';
      $message =  "Potential leads have been exported, Download it now.";
      $data = [
          'subject' => $subject,
          'greeting' => 'Hello {name},',
          'content' => [
             $message
        ],
        'actionUrl' => $link,
        'actionText' => 'Download Csv',
        'thankYouMessage' => 'Thank you'
      ];

      $user->notify(new MailNotifier($data));
    }



    public static function sendSubscriptionEmail($user,$plan='',$expire='')
    {   
        //send the welcome email first
        //MailManager::sendWelcomeMail($user);

        $access = '';


        if ($plan == SubscriptionConfig::STANDARD) {

           $access = "You now have access to ".config()->get('app.name')." Standard subscription";

        }elseif ($plan == SubscriptionConfig::STANDARD_GOLD) {
           $access = "You now have access to ".config()->get('app.name')." Standard Gold";

        }elseif($plan == SubscriptionConfig::MONTHLY){
           $access = "You now have access to ".config()->get('app.name')." Monthly subscription. Your subscription will expire on ".Utility::unixdatetime_to_text($expire)."";

        }
     
        //Config::set('mail.from.name', 'Agency Apps');

        $link = config('app.main_url');
        $subject = 'Welcome To ' .config()->get('app.name');

        $data = [
            'subject' => $subject,
            'greeting' => 'Hello {name}, You’re in, {name} Let’s get started.',
            'content' => [
                    "Thank you for purchasing ".config()->get('app.name'),
                    "<b>Login details:</b>",
                    "Email: ".$user->email,
                    "Password: ".$user->plain_password,
                    $access,
                    "You can reach out to support on: ".self::SUPPORT_EMAIL,
          ],
          'actionUrl' => $link,
          'actionText' => 'Login Here',
          'thankYouMessage' => 'Thank you'
        ];

        $user->notify(new MailNotifier($data));
    }


    public static function sendSubscriptionExtendedEmail($user,$plan='',$expire='')
    {   

        $link = config('app.main_url');

        $subject = 'Subscription Renewal -  ' .config()->get('app.name');
        $access = '';

        if ($plan == SubscriptionConfig::STANDARD) {
           $access = "You now have access to ".config()->get('app.name')." Standard subscription";

        }elseif ($plan == SubscriptionConfig::STANDARD_GOLD) {
           $access = "You now have access to ".config()->get('app.name')." Standard Gold";
      
        }elseif($plan == SubscriptionConfig::MONTHLY){
           $access = "You now have access to ".config()->get('app.name')." Monthly subscription. Your subscription will expire on ".Utility::unixdatetime_to_text($expire)."";

        }
     

        $data = [
            'subject' => $subject,
            'greeting' => 'Hello {name},',
            'content' => [
              "Thank you for choosing ".config()->get('app.name'),
              $access,
              "You can reach out to support on: ".self::SUPPORT_EMAIL,
          ],
          'actionUrl' => $link,
          'actionText' => 'Login Here',
          'thankYouMessage' => 'Thank you'
        ];

        $user->notify(new MailNotifier($data));
    }


    public static function sendSubscriptionCancelledEmail($user)
    { 
        $link = config('app.main_url');
        $data = [
            'subject' => 'Subscription Cancelled',
            'greeting' => 'Hello {name},',
            'content' => [
               "Your subscription to ".config()->get('app.name').". was cancelled.",
               "You wont be able to use our services till you optin again.",
               "You can reach out to support on: ".self::SUPPORT_EMAIL
          ],
          //'actionUrl' => $link,
          //'actionText' => 'Login Here',
          'thankYouMessage' => 'Thank you'
        ];

        $user->notify(new MailNotifier($data));
    }



    public static function sendAddonSubscriptionEmail($user,$plan='')
    { 
        $link = config('app.main_url');
        $access = '';
        $title = '';
        
        if($plan == SubscriptionConfig::STANDARD_SILVER){
           $access = "You now have access to ".config()->get('app.name')." Standard Silver";
           $title = 'Standard Silver';

        }elseif($plan == SubscriptionConfig::PRO){
           $access = "You now have access to ".config()->get('app.name')." Pro";
           $title = 'Pro';

        }elseif($plan == SubscriptionConfig::AGENCY){
           $access = "You now have access to ".config()->get('app.name')." Agency";
           $title = 'Agency';

        }elseif($plan == SubscriptionConfig::RESELLER){
           $access = "You now have access to ".config()->get('app.name')." Reseller";
           $title = 'Reseller';
        }

        $data = [
            'subject' => $title.' Plan enabled.',
            'greeting' => 'Hello {name},',
            'content' => [
              "Thank you for choosing ".config()->get('app.name'),
              $access,
              "You can reach out to support on: ".self::SUPPORT_EMAIL
           ],
          'actionUrl' => $link,
          'actionText' => 'Login Here',
          'thankYouMessage' => 'Thank you'
        ];

        $user->notify(new MailNotifier($data));

    }

    public static function sendAddonSubscriptionCancelledEmail($user,$plan='')
    {   
        $link = config('app.main_url');
        $title = '';

        if($plan == SubscriptionConfig::STANDARD_SILVER){
           $title = 'Standard Silver';

        }elseif($plan == SubscriptionConfig::PRO){
           $title = 'Pro';

        }elseif($plan == SubscriptionConfig::AGENCY){
           $title = 'Agency';

        }elseif($plan == SubscriptionConfig::RESELLER){
           $title = 'Reseller';
        }


        $data = [
            'subject' => $title.' Plan Cancelled',
            'greeting' => 'Hello {name},',
            'content' => [
              "Your subscription to ".config()->get('app.name')." ".$title." plan was cancelled.",
              "You wont be able to use this plan anymore.",
              "You can reach out to support on: ".self::SUPPORT_EMAIL
          ],
          //'actionUrl' => $link,
          //'actionText' => 'Login Here',
          'thankYouMessage' => 'Thank you'
        ];

        $user->notify(new MailNotifier($data));
    }




}

?>