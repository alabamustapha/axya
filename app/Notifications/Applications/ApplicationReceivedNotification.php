<?php

namespace App\Notifications\Applications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationReceivedNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
            ->subject('Application Received')
            ->line($this->user->name .', your application as a medical doctor was received successfully and will be reviewed within 48hours.')
            ->line('After verifying your details eventual administrator\'s decision (approval/rejection) will be passed across.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $timestamp = \Carbon\Carbon::now()->format('D M-d, h:ia');

        $message  = $timestamp .' - <strong>Application Received.</strong> <br>';
        $message .= $this->user->name .', your application as a medical doctor was received successfully';
        $message .= ' and will be reviewed within 48hours. <br>';
        $message .= 'After verifying your details eventual administrator\'s decision (approval/rejection) will be passed across.';

        return [ 'message' => $message ];
    }
}
