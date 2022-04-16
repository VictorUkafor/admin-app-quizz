<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Notifications\Traits\UserNotifierTrait;

class MailNotifier extends Notification implements ShouldQueue
{
    use Queueable;
    use UserNotifierTrait;

    /**
     * Create a new notification instance.
     *config('app.name')
     * @return void
     */
    public function __construct($data)
    {
        //Mailer uses parsedown
        $this->data = (object) $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
