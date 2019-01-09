<?php

namespace App\Notifications\Transactions;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionFailedNotification extends Notification //implements ShouldQueue
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
        return (new MailMessage)
            ->subject('Transaction Not Successful - Appointment Booking Fee')
            ->line($this->user->name .', your transaction with ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong> was not successful.')
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

        $message  = $timestamp .' - <strong>Transaction Not Successful - Appointment Booking Fee.</strong> <br>';
        $message .= $this->user->name .', your transaction with ID <strong><a href="'. route('transactions.show', $this->transaction) .'">'. $this->transaction->transaction_id .'</a></strong> was not successful. <br>';
        $message .= 'Please try again.';

        return [ 'message' => $message ];
    }
}
