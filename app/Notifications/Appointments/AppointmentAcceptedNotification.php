<?php

namespace App\Notifications\Appointments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentAcceptedNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;
    public $appointment;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $appointment)
    {
        $this->user = $user;
        $this->appointment = $appointment;
        $this->url = route('appointments.show', $this->appointment);
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
            ->subject('Appointment Accepted')
            ->line($this->user->name .', your appointment with <a href="'. route('doctors.show', $this->appointment->doctor->user) .'">'. $this->appointment->doctor->user->name .'</a> was accepted.')
            ->line('Promptly add further details with more form fields released and more importantly, pay your appointment fee of $'. $this->appointment->fee .' to secure the schedule.')
            ->action('Full Appointment Details', $this->url);
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

        $message  = $timestamp .' - <strong>Appointment Accepted.</strong> <br>';
        $message .= $this->user->name .', your appointment with <a href="'. route('doctors.show', $this->appointment->doctor->user) .'">'. $this->appointment->doctor->user->name .'</a> was accepted. <br>';
        $message .= 'Promptly add further details with more form fields released and more importantly, pay your appointment fee of $'. $this->appointment->fee .' to secure the schedule.<br>';
        $message .= 'Full Appointment Details avaliable <a href="'. $this->url .'">HERE/a>.';

        return [ 'message' => $message ];
    }
}
