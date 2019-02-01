<?php

namespace App\Notifications\Doctors;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DoctorPasswordResetNotification extends Notification //implements ShouldQueue
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
        $token = str_random(60);
        $notifiable->update(['verification_link' => $token]);

        $resetEmailLink = route('doctor.password.reset-email-verify', [
                                'token' => $token, 
                                'tc'    => md5($notifiable->created_at),
                                'email' => $notifiable->email,
                            ]); 

        return (new MailMessage)
            ->subject('Doctor Account Password Reset')
            ->line('Click the button below to reset your doctor\'s administration account password.')
            ->action('Password Reset Link', $resetEmailLink)
            ->line($resetEmailLink)
            ->line('If you did not authorize this password reset please click this button immediately...')
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

        $message  = $timestamp .' - <strong>Doctor Account Password Reset.</strong> <br>';
        $message .= 'A doctor\'s administration account password reset email was sent to you. Check your email inbox.<br>';
        $message .= 'If you did not authorize this password change please click the button immediately... <br>';
        // $message .= '<a href="'. route('freeze-presently-logged-in-admins-out') .' class="btn btn-lg btn-danger">Cancel Password Update</a>.';

        return [ 'message' => $message ];
    }
}
