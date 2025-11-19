<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BroadcastNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'type' => $this->data['type'] ?? 'info',
            'icon' => $this->data['icon'] ?? 'ℹ️',
            'action_url' => $this->data['action_url'] ?? null,
            'action_text' => $this->data['action_text'] ?? 'Lihat',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function toArray($notifiable): array
    {
        return $this->data;
    }
}
