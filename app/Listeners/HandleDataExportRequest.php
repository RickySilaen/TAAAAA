<?php

namespace App\Listeners;

use App\Events\DataExportRequested;
use Illuminate\Support\Facades\Log;

/**
 * Handle Data Export Request.
 *
 * Logs export activity and prepares for async export if needed.
 */
class HandleDataExportRequest
{
    /**
     * Handle the event.
     */
    public function handle(DataExportRequested $event): void
    {
        // Log the export request
        Log::info('Data export requested', $event->getData());

        // Track export activity
        activity()
            ->causedBy($event->userId)
            ->withProperties([
                'export_type' => $event->exportType,
                'format' => $event->format,
                'filters' => $event->filters,
            ])
            ->log('Data export requested');

        // For large exports, queue the job (future enhancement)
        // if ($this->isLargeExport($event->filters)) {
        //     dispatch(new ProcessDataExport($event));
        // }
    }

    /**
     * Determine if this is a large export.
     */
    private function isLargeExport(array $filters): bool
    {
        // Placeholder logic - determine based on date range, record count, etc.
        return false;
    }
}
