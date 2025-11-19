<?php

namespace App\Events;

use App\Models\Bantuan;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Bantuan Status Changed Event.
 *
 * Fired when the status of a bantuan request changes.
 */
class BantuanStatusChanged
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Bantuan $bantuan,
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
            'bantuan_id' => $this->bantuan->id,
            'user_id' => $this->bantuan->user_id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'changed_by' => $this->changedBy,
            'changed_at' => now()->toDateTimeString(),
        ];
    }
}
