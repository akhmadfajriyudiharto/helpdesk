<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use stdClass;

class UserRegister extends Notification
{
    use Queueable;

    private $notificationData;

    /**
     * Create a new notification instance.
     *
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
        return ['mail', 'database'];
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
            ->success()
            ->subject(__('Confirmation of your account registration'))
            ->greeting(__('Welcome').' '.$this->notificationData->user->name.',')
            ->line(__('We confirm that you have successfully registered on our website, you can access using the following link').':')
            ->action(__('Access the site'), url('/'))
            ->line(__('If you have not registered yourself, someone has used this email address, we recommend that you contact the administrators').'.');
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
