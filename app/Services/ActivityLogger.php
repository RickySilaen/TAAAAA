<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    /**
     * Log user activity.
     */
    public function log(string $action, string $model, ?int $modelId = null, array $data = []): void
    {
        $context = [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name,
            'user_role' => Auth::user()?->role,
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        if (! empty($data)) {
            $context['data'] = $data;
        }

        Log::channel('activity')->info("User activity: {$action} on {$model}", $context);
    }

    /**
     * Log user authentication.
     */
    public function logAuth(string $action, ?int $userId = null, bool $success = true): void
    {
        $context = [
            'user_id' => $userId,
            'action' => $action,
            'success' => $success,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        $level = $success ? 'info' : 'warning';
        $message = $success ? "Auth successful: {$action}" : "Auth failed: {$action}";

        Log::channel('auth')->{$level}($message, $context);
    }

    /**
     * Log verification action.
     */
    public function logVerification(int $petaniId, string $action, ?string $reason = null): void
    {
        $context = [
            'petugas_id' => Auth::id(),
            'petugas_name' => Auth::user()?->name,
            'petani_id' => $petaniId,
            'action' => $action,
            'reason' => $reason,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('verification')->info("Verification: {$action} for petani #{$petaniId}", $context);
    }

    /**
     * Log bantuan/laporan status change.
     */
    public function logStatusChange(string $type, int $id, string $oldStatus, string $newStatus, ?string $notes = null): void
    {
        $context = [
            'changed_by' => Auth::id(),
            'changed_by_name' => Auth::user()?->name,
            'type' => $type,
            'item_id' => $id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('status')->info("Status change: {$type} #{$id} from {$oldStatus} to {$newStatus}", $context);
    }

    /**
     * Log file upload.
     */
    public function logFileUpload(string $type, string $filename, int $size, ?string $path = null): void
    {
        $context = [
            'user_id' => Auth::id(),
            'type' => $type,
            'filename' => $filename,
            'size' => $size,
            'size_formatted' => $this->formatBytes($size),
            'path' => $path,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('files')->info("File uploaded: {$filename}", $context);
    }

    /**
     * Log error with context.
     */
    public function logError(\Throwable $e, array $context = []): void
    {
        $errorContext = [
            'user_id' => Auth::id(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip_address' => request()->ip(),
            'timestamp' => now()->toDateTimeString(),
        ];

        $errorContext = array_merge($errorContext, $context);

        Log::error('Application error', $errorContext);
    }

    /**
     * Log security event.
     */
    public function logSecurity(string $event, string $severity = 'info', array $context = []): void
    {
        $securityContext = [
            'user_id' => Auth::id(),
            'event' => $event,
            'severity' => $severity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ];

        $securityContext = array_merge($securityContext, $context);

        Log::channel('security')->{$severity}("Security event: {$event}", $securityContext);
    }

    /**
     * Format bytes to human readable.
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
