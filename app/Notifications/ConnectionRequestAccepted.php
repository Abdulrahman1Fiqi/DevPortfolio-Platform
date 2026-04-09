<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ConnectionRequest;

class ConnectionRequestAccepted extends Notification
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
        $developer = $this->connectionRequest->developer;

        return (new MailMessage)
            ->subject($developer->name . ' accepted your connection request!')
            ->greeting('Great news, '. $notifiable->name . '!')
            ->line($developer->name .' accepted your connection request.')
            ->line('You can now reach them at: ' . $developer->email)
            ->action('View Your Connections', 
                route('recruiter.connections.index')
                );
            
    }

    
}
