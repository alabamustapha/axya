<?php

namespace App\Notifications\Transactions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionSuccessfulNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $user;
    public $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $transaction)
    {
        $this->user = $user;
        $this->transaction = $transaction;
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
        if ($notifiable->id == $this->transaction->user_id){
        return (new MailMessage)
            ->subject('Transaction Successful - Appointment Booking Fee')
            ->line($this->transaction->user->name .', your transaction with ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong> was successful.')
            ->line('The attending doctor, '. $this->transaction->doctor->name .' has been notified. You may start messaging at the set time.');
        }
        if ($notifiable->id == $this->transaction->doctor->id){
        return (new MailMessage)
            ->subject('Transaction Successful - Patient Appointment Booking Fee')
            ->line('Dear '. $this->transaction->doctor->name .', your patient '. $this->transaction->user->name .', made a successful payment with the transaction ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong>.')
            ->line('Kindly take note of the appointment time: '. $this->transaction->appointment->from .' and be avaialble. <br> You may start messaging at the set time.');
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

        if ($notifiable->id == $this->transaction->user_id){
            $message  = $timestamp .' - <strong>Transaction  Successful - Appointment Booking Fee.</strong> <br>';
            $message .= $this->transaction->user->name .', your transaction with ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong> was successful. <br>';
            $message .= 'The attending doctor, '. $this->transaction->doctor->name .' has been notified. You may start messaging at the set time.';
        }
        if ($notifiable->id == $this->transaction->doctor->id){
            $message  = $timestamp .' - <strong>Transaction  Successful - Patient Appointment Booking Fee.</strong> <br>';
            $message .= 'Dear '. $this->transaction->doctor->name .', your patient '. $this->transaction->user->name .', made a successful payment with the transaction ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong>.';
            $message .= 'Kindly take note of the appointment time: '. $this->transaction->appointment->from .' and be avaialble. <br> You may start messaging at the set time.';
        }

        return [ 'message' => $message ];
    }
}
