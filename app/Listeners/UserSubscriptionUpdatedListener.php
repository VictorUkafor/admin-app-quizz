<?php

namespace App\Listeners;

use Log;
use \GuzzleHttp\Client;
use App\Helpers\EventHelper;
use App\Models\WebhookModel;
use App\Events\UserSubscriptionUpdatedEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSubscriptionUpdatedListener
{
    private $eventName = EventHelper::SUBSCRIPTION_UPDATE;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserSubscriptionUpdatedEvent $event)
    {
        $webHooks = WebhookModel::where('event', $this->eventName)->get();
        Log::info($event->user);

        foreach($webHooks as $webHook){
            $this->makeRequest($webHook->webhook_url, $event->user, $event->subscription);
        }
    }

    private function makeRequest($url, $user, $sub){
        try{
            $client = new Client();

            $res = $client->request('POST', $url, [
                'form_params' => [
                    "user" => [
                        "message" => "User Updated",
                        "name" => $user->name,
                        "email" => $user->email,
                        "phone" => $user->phone,
                        "is_active" => $user->is_active,
                        "user_type" => $user->user_type
                    ],
                    "sub_details" => [
                        "start_date" => $sub->start_date,
                        "end_date" => $sub->end_date,
                        "is_active" => $sub->is_active,
                        "type" => $sub->type,
                        "user_id" => $sub->user_id,
                        "addons" => $sub->addons,
                    ]
                ]

            ]);


            $contents = $res->getBody()->getContents();


        }catch(\Exception $error){
            Log::info($error);
        }
    }
}
