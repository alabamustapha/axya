<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminPasswordChangeNotification extends Notification //implements ShouldQueue
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
            ->subject('Admin Account Password Change')
            ->line($this->user->name .', your app administrator account password update was successful.')
            ->line('If you did not authorize this password change please click this button immediately...')
            // ->action('Cancel Password Update', route('freeze-presently-logged-in-admins-out'))
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
        $timestamp = \Carbon\Carbon::now()->format('D M-d, h:ia');

        $message  = $timestamp .' - <strong>Admin Account Password Change.</strong> <br>';
        $message.= $this->user->name .', your app administrator account password update was successful. <br>';
        $message .= 'If you did not authorize this password change please click the button immediately... <br>';
        // $message .= '<a href="'. route('freeze-presently-logged-in-admins-out') .' class="btn btn-lg btn-danger">Cancel Password Update</a>.';

        return [ 'message' => $message ];
    }
}
