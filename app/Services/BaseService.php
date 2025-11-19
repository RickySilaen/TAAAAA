<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * Base Service Class.
 *
 * Provides common functionality for all service classes including
 * logging, error handling, and standardized response format.
 */
abstract class BaseService
{
    /**
     * Success response wrapper.
     *
     * @param  mixed  $data
     * @return array{success: bool, data: mixed, message: string|null}
     */
    protected function success($data, ?string $message = null): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * Error response wrapper.
     *
     * @param  mixed  $errors
     * @return array{success: bool, message: string, errors: mixed, code: int}
     */
    protected function error(string $message, $errors = null, int $code = 400): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $code,
        ];
    }

    /**
     * Log information message.
     */
    protected function logInfo(string $message, array $context = []): void
    {
        Log::info($this->getLogPrefix() . $message, $context);
    }

    /**
     * Log error message.
     */
    protected function logError(string $message, array $context = []): void
    {
        Log::error($this->getLogPrefix() . $message, $context);
    }

    /**
     * Log warning message.
     */
    protected function logWarning(string $message, array $context = []): void
    {
        Log::warning($this->getLogPrefix() . $message, $context);
    }

    /**
     * Get log prefix with service class name.
     */
    private function getLogPrefix(): string
    {
        return '[' . class_basename($this) . '] ';
    }

    /**
     * Execute a callable within a try-catch block with logging.
     *
     * @return array{success: bool, data?: mixed, message?: string, errors?: mixed, code?: int}
     */
    protected function executeWithErrorHandling(callable $callback, string $errorMessage = 'Operation failed'): array
    {
        try {
            $result = $callback();

            return $this->success($result);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logWarning($errorMessage, [
                'errors' => $e->errors(),
            ]);

            return $this->error($errorMessage, $e->errors(), 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->logWarning('Resource not found', [
                'model' => $e->getModel(),
            ]);

            return $this->error('Resource not found', null, 404);
        } catch (\Exception $e) {
            $this->logError($errorMessage, [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->error($errorMessage, $e->getMessage(), 500);
        }
    }

    /**
     * Validate required parameters.
     *
     *
     * @throws \InvalidArgumentException
     */
    protected function validateRequired(array $data, array $required): void
    {
        $missing = array_diff($required, array_keys($data));

        if (! empty($missing)) {
            throw new \InvalidArgumentException(
                'Missing required parameters: ' . implode(', ', $missing)
            );
        }
    }
}
