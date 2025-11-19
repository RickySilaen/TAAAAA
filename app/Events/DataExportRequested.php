<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Data Export Requested Event.
 *
 * Fired when user requests data export (Excel/PDF).
 */
class DataExportRequested
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $exportType,
        public string $format,
        public int $userId,
        public array $filters = []
    ) {}

    /**
     * Get the data for event.
     */
    public function getData(): array
    {
        return [
            'export_type' => $this->exportType,
            'format' => $this->format,
            'user_id' => $this->userId,
            'filters' => $this->filters,
            'requested_at' => now()->toDateTimeString(),
        ];
    }
}
