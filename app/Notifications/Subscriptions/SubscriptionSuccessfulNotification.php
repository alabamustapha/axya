<?php

namespace App\Notifications\Subscriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionSuccessfulNotification extends Notification //implements ShouldQueue
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
        if ($notifiable->id == $this->subscription->user_id){
        return (new MailMessage)
            ->subject('Subscription Successful')
            ->line($this->subscription->user->name .', your subscription with ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong> was successful.')
            ->line('Your status has been updated as available for appointment. You may start receiving appointments from patients immediately. <br>
                Kindly give all your patients the best so they can leave positive ratings in their reviews of your service delivery.');
        }
        if ($notifiable->is_admin){
        return (new MailMessage)
            ->subject('Subscription Notification')
            ->line('A new subscription has been made by <a href="'. route('doctors.show', $this->subscription->doctor) .'">'. $this->subscription->doctor->name .'</a>') 
            ->line('Transaction ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong>.')
            ->line('Time: '. $this->subscription->confirmed_at .'.');
        }
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

        if ($notifiable->id == $this->subscription->user_id){
            $message  = $timestamp .' - <strong>Subscription  Successful.</strong> <br>';
            $message .= $this->subscription->user->name .', your subscription with ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong> was successful. <br>';
            $message .= 'Your status has been updated as available for appointment. You may start receiving appointments from patients immediately. <br>
            Kindly give all your patients the best so they can leave positive ratings in their reviews of your service delivery.';
        }
        if ($notifiable->is_admin){
            $message  = $timestamp .' - <strong>Subscription  Notification.</strong> <br>';
            $message .= 'A new subscription has been made by <a href="'. route('doctors.show', $this->subscription->doctor) .'">'. $this->subscription->doctor->name .'</a> <br>'; 
            $message .= 'Transaction ID <strong><a href="'. route('subscriptions.show', $this->subscription) .'">'. $this->subscription->transaction_id .'</a></strong>. <br>';
            $message .= 'Time: '. $this->subscription->confirmed_at .'.';
        }

        return [ 'message' => $message ];
    }
}
