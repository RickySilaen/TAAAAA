<?php

namespace App\Listeners;

use App\Events\LaporanStatusChanged;
use App\Notifications\LaporanCreated;
use Illuminate\Support\Facades\Log;

/**
 * Handle Laporan Status Change.
 *
 * Sends notifications when laporan status changes.
 */
class HandleLaporanStatusChange
{
    /**
     * Handle the event.
     */
    public function handle(LaporanStatusChanged $event): void
    {
        $laporan = $event->laporan;
        $newStatus = $event->newStatus;

        // Log the status change
        Log::info('Laporan status changed', $event->getData());

        // Send notification to petani
        if ($laporan->user) {
            $message = $this->getNotificationMessage($newStatus);

            $laporan->user->notify(
                new LaporanCreated($laporan, $message)
            );
        }

        // If verified, update statistics cache
        if ($newStatus === 'terverifikasi') {
            cache()->forget('dashboard_statistics');
            cache()->forget('harvest_summary');

            Log::info('Laporan verified - statistics cache cleared', [
                'laporan_id' => $laporan->id,
            ]);
        }
    }

    /**
     * Get notification message based on status.
     */
    private function getNotificationMessage(string $status): string
    {
        return match ($status) {
            'terverifikasi' => 'Laporan panen Anda telah diverifikasi.',
            'ditolak' => 'Laporan panen Anda ditolak. Silakan periksa kembali data yang Anda masukkan.',
            'pending' => 'Laporan panen Anda sedang diverifikasi.',
            default => 'Status laporan panen Anda telah diperbarui.',
        };
    }
}
