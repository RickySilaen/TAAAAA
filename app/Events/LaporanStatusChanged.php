<?php

namespace App\Events;

use App\Models\Laporan;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Laporan Status Changed Event.
 *
 * Fired when the status of a laporan changes.
 */
class LaporanStatusChanged
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Laporan $laporan,
        public string $oldStatus,
        public string $newStatus,
        public ?string $changedBy = null
    ) {}

    /**
     * Get the data for event.
     */
    public function getData(): array
    {
        return [
            'laporan_id' => $this->laporan->id,
            'user_id' => $this->laporan->user_id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'changed_by' => $this->changedBy,
            'changed_at' => now()->toDateTimeString(),
        ];
    }
}
