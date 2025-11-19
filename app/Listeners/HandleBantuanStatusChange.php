<?php

namespace App\Listeners;

use App\Events\BantuanStatusChanged;
use App\Notifications\BantuanCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

/**
 * Handle Bantuan Status Change.
 *
 * Sends notifications when bantuan status changes.
 */
class HandleBantuanStatusChange
{
    /**
     * Handle the event.
     */
    public function handle(BantuanStatusChanged $event): void
    {
        $bantuan = $event->bantuan;
        $newStatus = $event->newStatus;

        // Log the status change
        Log::info('Bantuan status changed', $event->getData());

        // Send notification to petani
        if ($bantuan->user) {
            $message = $this->getNotificationMessage($newStatus);

            $bantuan->user->notify(
                new BantuanCreated($bantuan, $message)
            );
        }

        // If approved, notify admin for follow-up
        if ($newStatus === 'disetujui' && $event->changedBy) {
            Log::info('Bantuan approved - follow-up required', [
                'bantuan_id' => $bantuan->id,
                'approved_by' => $event->changedBy,
            ]);
        }
    }

    /**
     * Get notification message based on status.
     */
    private function getNotificationMessage(string $status): string
    {
        return match ($status) {
            'disetujui' => 'Permohonan bantuan Anda telah disetujui.',
            'ditolak' => 'Permohonan bantuan Anda ditolak. Silakan hubungi petugas untuk informasi lebih lanjut.',
            'menunggu' => 'Permohonan bantuan Anda sedang diproses.',
            default => 'Status permohonan bantuan Anda telah diperbarui.',
        };
    }
}
