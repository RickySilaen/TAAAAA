<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaporanCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $laporan;

    /**
     * Create a new notification instance.
     */
    public function __construct($laporan)
    {
        $this->laporan = $laporan;
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
            'title' => 'Laporan Baru Dibuat',
            'message' => "Laporan dengan hasil panen {$this->laporan->hasil_panen} kg telah dibuat.",
            'laporan_id' => $this->laporan->id,
            'hasil_panen' => $this->laporan->hasil_panen,
            'deskripsi_kemajuan' => $this->laporan->deskripsi_kemajuan,
            'tanggal' => $this->laporan->tanggal,
            'type' => 'laporan_created',
            'icon' => 'fas fa-file-lines',
            'color' => 'primary',
        ];
    }
}
