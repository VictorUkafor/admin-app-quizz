<?php

namespace App\Listeners;

use Log;
use \GuzzleHttp\Client;
use App\Helpers\EventHelper;
use App\Models\WebhookModel;
use App\Events\UserCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener
{
    private $eventName = EventHelper::USER_CREATED;
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
    public function handle(UserCreatedEvent $event)
    {
        $webHooks = WebhookModel::where('event', $this->eventName)->get();
        Log::info($event->user);

        foreach($webHooks as $webHook){
            $this->makeRequest($webHook->webhook_url, $event->user);
        }
    }

    private function makeRequest($url, $user){
        try{
            $client = new Client();

            $res = $client->request('POST', $url, [
                'form_params' => [
                    "message" => "User Created",
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "is_active" => $user->is_active,
                    "user_type" => $user->user_type
                ]

            ]);


            $contents = $res->getBody()->getContents();


        }catch(\Exception $error){
            Log::info($error);
        }
    }
}
