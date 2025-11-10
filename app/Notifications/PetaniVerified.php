<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class PetaniVerified extends Notification
{
    use Queueable;

    protected $petugas;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $petugas)
    {
        $this->petugas = $petugas;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Akun Terverifikasi',
            'message' => 'Selamat! Akun Anda telah diverifikasi oleh ' . $this->petugas->name . '. Anda sekarang dapat login ke sistem.',
            'petugas_name' => $this->petugas->name,
            'verified_at' => now()->format('d/m/Y H:i'),
            'action_url' => route('login'),
            'type' => 'petani_verified',
            'icon' => 'fa-check-circle',
            'color' => 'success',
        ];
    }
}

