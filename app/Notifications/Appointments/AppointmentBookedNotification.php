<?php

namespace App\Notifications\Appointments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentBookedNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;
    public $appointment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $appointment)
    {
        $this->user = $user;
        $this->appointment = $appointment;
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
            ->subject('Appointment Booked')
            ->line($this->user->name .', you have booked an appointment with <a href="'. route('doctors.show', $this->appointment->doctor->user) .'">'. $this->appointment->doctor->user->name .'</a> on this platform.')
            ->line($this->appointment->doctor->user->name .' has been notified. Keep checking the <a href="'. route('appointments.show', $this->appointment) .'">appointment page</a> for confirmation and further updates.');
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

        $message  = $timestamp .' - <strong>Appointment Booked.</strong> <br>';
        $message .= $this->user->name .', you have booked an appointment with <a href="'. route('doctors.show', $this->appointment->doctor->user) .'">'. $this->appointment->doctor->user->name .'</a> on this platform. <br>';
        $message .= $this->appointment->doctor->user->name .' has been notified. Keep checking the <a href="'. route('appointments.show', $this->appointment) .'">appointment page</a> for confirmation and further updates.';

        return [ 'message' => $message ];
    }
}
