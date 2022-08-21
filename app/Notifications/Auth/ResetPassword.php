<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use stdClass;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Email variables.
     *
     * @var stdClass
     */
    public $notificationData;

    /**
     * Create a new notification instance.
     *
     * ResetPassword constructor.
     * @param  stdClass  $objNotificationData
     */
    public function __construct(stdClass $objNotificationData)
    {
        $this->notificationData = $objNotificationData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Recover account'))
            ->greeting(__('Hi').' '.$this->notificationData->user->name.',')
            ->line(__('You are receiving this email because we received a password reset request for your account').'.')
            ->action(__('Reset password'), url('/auth/reset/'.$this->notificationData->token).'?email='.urlencode($notifiable->email))
            ->line(__('If you did not request a password reset, no further action is required').'.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
