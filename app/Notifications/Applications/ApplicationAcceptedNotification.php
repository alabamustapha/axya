<?php

namespace App\Notifications\Applications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApplicationAcceptedNotification extends Notification //implements ShouldQueue
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
            ->subject('Application Accepted')
            ->line($this->user->name .', your application as a medical doctor was accepted. You may now attend to patients and receive appointments on this platform.<br>')
            ->line('You now have access to a <strong>Doctor Section</strong> and your professional dashboard can be accessed at: ')
            ->line('<a href="'. route('doctors.show', $this->user) .'">'. route('doctors.show', $this->user) .'</a><br>')
            ->line('You must be <strong>SUBSCRIBED</strong> to have access to patients and appointments. <a href="#">Subscribe Now</a>');
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

        $message  = $timestamp .' - <strong>Application Accepted.</strong> <br>';
        $message .= $this->user->name .', your application as a medical doctor was accepted. You may now attend to patients and receive appointments on this platform. <br><br>';
        $message .= 'You now have access to a <strong>Doctor Section</strong> and your professional dashboard can be accessed at: <br>';
        $message .= '<a href="'. route('doctors.show', $this->user) .'">'. route('doctors.show', $this->user) .'</a></br><br>';
        $message .= 'You must be <strong>SUBSCRIBED</strong> to have access to patients and appointments. <a href="#">Subscribe Now</a>';

        return [ 'message' => $message ];
    }
}
