<?php
namespace App\Notifications\Traits;

use Illuminate\Notifications\Messages\MailMessage;
use App\Helpers\Utility;
use Parsedown;

Trait UserNotifierTrait {

	protected $data;
	protected $notifiable;

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
	    $this->notifiable = $notifiable;

	    $mailMessage = (new MailMessage)
	        ->subject( $this->parseText($this->data->subject, false) )
	        ->greeting( $this->parseText($this->data->greeting, false) )
	        ->markdown('vendor.notifications.email');
	    
	    if (is_string($this->data->content))
	    {
	    	$mailMessage = $mailMessage->line( $this->parseText($this->data->content) );
	    }
	    elseif (is_array($this->data->content)) {
	    	foreach ($this->data->content as $content) {
	    		$mailMessage = $mailMessage->line( $this->parseText($content) );
	    	}
	    }

	    if ( !empty($this->data->actionUrl) )
	    {
	        $mailMessage = $mailMessage->action($this->data->actionText ?? 'Learn more', 
	            url(Utility::httpify($this->data->actionUrl)));
	    }

	    if ( !empty($this->data->moreMailContent) )
	    {
	    	if (is_string($this->data->moreMailContent))
	    	{
	    		$mailMessage = $mailMessage->line( $this->parseText($this->data->moreMailContent) );
	    	}
	    	elseif (is_array($this->data->moreMailContent)) {
	    		foreach ($this->data->moreMailContent as $moreMailContent) {
	    			$mailMessage = $mailMessage->line( $this->parseText($moreMailContent) );
	    		}
	    	}
	    }


	    if ( !empty($this->data->thankYouMessage) )
	        $mailMessage = $mailMessage->line( $this->parseText($this->data->thankYouMessage) );
	    
	    if ( !empty($this->data->salutation) )
	        $mailMessage = $mailMessage->salutation($this->data->salutation);

	    return $mailMessage;
	}

	protected function parseText($txt, $parseDown = true) {
	   
	    $Parsedown = new Parsedown();

	    $parsedText = str_replace('{name}', ucfirst($this->notifiable->name), $txt);
	    $parsedText = str_replace('{email}', ucfirst($this->notifiable->email), $parsedText);

	    if ($parseDown === true)
	        return $Parsedown->text($parsedText);
	    
	    return $parsedText;
	}
}