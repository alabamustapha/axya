<?php

namespace App\Notifications\Prescriptions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPrescriptionNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $patient;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($prescription)
    {
        $this->patient      = $prescription->appointment->user;
        $this->prescription = $prescription;
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
            ->subject( 'New Prescription' )
            ->line( $this->patient->name .', <strong>'. $this->prescription->doctor->name .'</strong> has prescribed some medications for you in this <strong><a href="'. $this->prescription->appointment->link .'">appointment</a></strong>.' )
            ->line( 'Here is a link to it: ')
            ->action('View Now', $this->prescription->message->alternate_link)
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
        $timestamp = \Carbon\Carbon::now()->format('h:ia');//()->format('D M-d, h:ia') = Sun Feb-10, 03:43pm;

        $message  = $timestamp .' - <strong>New Prescription</strong> <br>';
        $message .= $this->patient->name .', <strong>'. $this->prescription->doctor->name .'</strong> has prescribed some medications for you in this <strong><a href="'. $this->prescription->appointment->link .'">appointment</a></strong>. <br>';
        $message .= 'Here is a link to it: <i class="fa fa-prescription"></i>&nbsp; <a href="'. $this->prescription->message->alternate_link.'">View Now</a>';

        return [ 'message' => $message ];
    }
}
