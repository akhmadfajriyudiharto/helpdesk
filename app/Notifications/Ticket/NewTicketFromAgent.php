<?php

namespace App\Notifications\Ticket;

use App\Models\Setting;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use stdClass;
use Str;

class NewTicketFromAgent extends Notification
{
    use Queueable;

    private $ticket;

    /**
     * Create a new notification instance.
     *
     * @param  Ticket  $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
            ->subject(__('New ticket').': '.Str::limit($this->ticket->subject, 35))
            ->greeting(__('Hi').' '.$this->ticket->user->name.',')
            ->line(__('We have created a new ticket, you can see the details in this link').':')
            ->action(__('See ticket'), url('/tickets/'.$this->ticket->uuid))
            ->line(__('In order to view the ticket you have to log in with your email and password, if you do not remember the password, you can reset it using the email account that this message has reached').'.');
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
