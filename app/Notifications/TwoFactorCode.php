<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TwoFactorCode extends Notification
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Two-Factor Authentication Code')
            ->line('Your two-factor authentication code is: ' . $this->code)
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this code, please ignore this email.');
    }
}