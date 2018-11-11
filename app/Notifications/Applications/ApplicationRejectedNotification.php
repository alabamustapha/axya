<?php

namespace App\Notifications\Applications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationRejectedNotification extends Notification //implements ShouldQueue
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
            ->subject('Application Rejected')
            ->line($this->user->name .', your application as a medical doctor was rejected, you may apply again in 7 days.')
            ->line('We could not accept your application at this time because your information and documents does not meet up to our qualification.');
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

        $message  = $timestamp .' - <strong>Application Rejected.</strong> <br>';
        $message .= $this->user->name .', your application as a medical doctor was rejected, you may apply again in 7 days. <br>';
        $message .= 'We could not accept your application at this time because your information and documents does not meet up to our qualification.';

        return [ 'message' => $message ];
    }
}
