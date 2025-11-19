<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage())
            ->subject($this->data['title'])
            ->greeting('Halo, ' . $notifiable->nama_lengkap . '!')
            ->line($this->data['message']);

        // Add action button if URL is provided
        if (! empty($this->data['action_url'])) {
            $message->action(
                $this->data['action_text'] ?? 'Lihat Detail',
                $this->data['action_url']
            );
        }

        // Add additional lines if provided
        if (! empty($this->data['additional_lines'])) {
            foreach ($this->data['additional_lines'] as $line) {
                $message->line($line);
            }
        }

        $message->line('Terima kasih telah menggunakan Sistem Informasi Pertanian!');

        // Set level based on type
        $level = match ($this->data['type'] ?? 'info') {
            'success' => 'success',
            'error' => 'error',
            'warning' => 'warning',
            default => 'info',
        };
        $message->level($level);

        return $message;
    }

    public function toArray($notifiable): array
    {
        return $this->data;
    }
}
