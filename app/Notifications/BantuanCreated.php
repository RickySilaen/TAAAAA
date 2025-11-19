<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BantuanCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bantuan;

    /**
     * Create a new notification instance.
     */
    public function __construct($bantuan)
    {
        $this->bantuan = $bantuan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Bantuan Baru Dibuat',
            'message' => "Bantuan {$this->bantuan->jenis_bantuan} dengan jumlah {$this->bantuan->jumlah} telah dibuat.",
            'bantuan_id' => $this->bantuan->id,
            'jenis_bantuan' => $this->bantuan->jenis_bantuan,
            'jumlah' => $this->bantuan->jumlah,
            'status' => $this->bantuan->status,
            'type' => 'bantuan_created',
            'icon' => 'fas fa-plus-circle',
            'color' => 'info',
        ];
    }
}
