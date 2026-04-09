<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ConnectionRequest;

class ConnectionRequestReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private ConnectionRequest $connectionRequest
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $recruiter = $this->connectionRequest->recruiter;
        return (new MailMessage)
            ->subject('New Connection Request from '. $recruiter->name)
            ->greeting('Hi '. $notifiable->name . '!')
            ->line($recruiter->name . ' wants to connect with you.')
            ->when(
                $this->connectionRequest->message,
                fn($mail) => $mail->line(
                    'Their message: "'. $this->connectionRequest->message . '"'
                )
            )
            ->action('View Connection Requests',
             route('developer.connections.index')
             )
            ->line('You can accept or decline from your dashboard.');
    }

}
