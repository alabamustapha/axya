<?php

namespace App\Notifications\Subscriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionFailedNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;
    public $subscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
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
            ->subject('Subscription Not Successful')
            ->line($this->user->name .', your subscription with ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong> was not successful.')
            ->line('Please try again.');
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

        $message  = $timestamp .' - <strong>Subscription Not Successful</strong> <br>';
        $message .= $this->user->name .', your subscription with ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong> was not successful. <br>';
        $message .= 'Please try again.';

        return [ 'message' => $message ];
    }
}
