<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class PetaniRegistered extends Notification
{
    use Queueable;

    protected $petani;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $petani)
    {
        $this->petani = $petani;
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
            'title' => 'Pendaftaran Petani Baru',
            'message' => 'Petani baru "' . $this->petani->name . '" dari desa ' . $this->petani->alamat_desa . ' telah mendaftar dan menunggu verifikasi.',
            'petani_id' => $this->petani->id,
            'petani_name' => $this->petani->name,
            'petani_email' => $this->petani->email,
            'petani_desa' => $this->petani->alamat_desa,
            'action_url' => route('petugas.petani.show', $this->petani->id),
            'type' => 'petani_registered',
            'icon' => 'fa-user-plus',
            'color' => 'warning',
        ];
    }
}

