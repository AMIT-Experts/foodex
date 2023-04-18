<?php

namespace App\Notifications;

use Ichtrojan\Otp\Models\Otp;
use Illuminate\Bus\Queueable;
use Ichtrojan\Otp\Otp as OtpOtp;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerficationNotification extends Notification
{
    use Queueable;
    public $massage;
    public $subject;
    public $fromemail;
    public $mailer;
    public $otp;
    

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->massage='use the belue code for verification process';
        $this->subject='verification needed';
        $this->fromemail='test@foodex.com';
        $this->mailer='smtp';
        $this->otp= new Otp;


    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['email'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail( $notifiable): MailMessage
    {
        $otp=$this->otp->generate($notifiable->email,6,15);
        return (new MailMessage)
                    ->mailer('smtp')
                    ->subject($this->subject)
                    ->greeting('Hello'.$notifiable->name)
                    ->line($this->massage)
                    ->line('code:   '.$otp->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
