<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendAdminNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = '';

        $via .= $this->notification->as_email  ? 'mail,'     : '';
        $via .= $this->notification->as_notice ? 'database,' : '';
        // $via .= $this->notification->as_push   ? 'channel,'  : '';
        // $via .= $this->notification->as_text   ? 'nexmo'    : '';

        $channels = explode(',', $via);

        return $channels; // ['mail','database','slack','nexmo'...];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject( $this->notification->title )
            ->line( $this->notification->content )
            // ->action('JD Link', $jdLink) // if link exists in content
            ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $message  = '<strong>'. $this->notification->title .'.</strong> <br>';
        $message .= $this->notification->content;

        return [ 'message' => $message ];
    }
}
