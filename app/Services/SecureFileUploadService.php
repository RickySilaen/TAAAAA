<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Secure File Upload Service
 * Provides comprehensive file upload validation and security.
 */
class SecureFileUploadService
{
    /**
     * Allowed MIME types for uploads.
     */
    private const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    private const ALLOWED_DOCUMENT_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    /**
     * Maximum file sizes (in bytes).
     */
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
    private const MAX_DOCUMENT_SIZE = 10 * 1024 * 1024; // 10MB

    /**
     * Validate and upload image file.
     */
    public function uploadImage(UploadedFile $file, string $directory = 'images'): array
    {
        // Validate file
        $this->validateImage($file);

        // Generate secure filename
        $filename = $this->generateSecureFilename($file);

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return [
            'success' => true,
            'path' => $path,
            'filename' => $filename,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Validate and upload document file.
     */
    public function uploadDocument(UploadedFile $file, string $directory = 'documents'): array
    {
        // Validate file
        $this->validateDocument($file);

        // Generate secure filename
        $filename = $this->generateSecureFilename($file);

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return [
            'success' => true,
            'path' => $path,
            'filename' => $filename,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Validate image file.
     */
    private function validateImage(UploadedFile $file): void
    {
        // Check if file is valid
        if (! $file->isValid()) {
            throw new \Exception('File upload failed');
        }

        // Validate MIME type
        $mimeType = $file->getMimeType();
        if (! in_array($mimeType, self::ALLOWED_IMAGE_MIMES)) {
            throw new \Exception('Invalid image type. Allowed: JPG, PNG, GIF, WEBP');
        }

        // Validate file size
        if ($file->getSize() > self::MAX_IMAGE_SIZE) {
            throw new \Exception('Image size must be less than 5MB');
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            throw new \Exception('Invalid file extension');
        }

        // Check if file is actually an image
        $imageInfo = @getimagesize($file->getRealPath());
        if ($imageInfo === false) {
            throw new \Exception('File is not a valid image');
        }

        // Validate image dimensions (optional)
        [$width, $height] = $imageInfo;
        if ($width > 5000 || $height > 5000) {
            throw new \Exception('Image dimensions too large (max 5000x5000)');
        }

        // Check for double extensions
        if (substr_count($file->getClientOriginalName(), '.') > 1) {
            throw new \Exception('Invalid filename: multiple extensions detected');
        }
    }

    /**
     * Validate document file.
     */
    private function validateDocument(UploadedFile $file): void
    {
        // Check if file is valid
        if (! $file->isValid()) {
            throw new \Exception('File upload failed');
        }

        // Validate MIME type
        $mimeType = $file->getMimeType();
        if (! in_array($mimeType, self::ALLOWED_DOCUMENT_MIMES)) {
            throw new \Exception('Invalid document type. Allowed: PDF, DOC, DOCX, XLS, XLSX');
        }

        // Validate file size
        if ($file->getSize() > self::MAX_DOCUMENT_SIZE) {
            throw new \Exception('Document size must be less than 10MB');
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
            throw new \Exception('Invalid file extension');
        }

        // Check for double extensions
        if (substr_count($file->getClientOriginalName(), '.') > 1) {
            throw new \Exception('Invalid filename: multiple extensions detected');
        }

        // Scan for malicious content (basic check)
        $this->scanFileContent($file);
    }

    /**
     * Generate secure random filename.
     */
    private function generateSecureFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $randomName = Str::random(40);
        $timestamp = time();

        return "{$randomName}_{$timestamp}.{$extension}";
    }

    /**
     * Basic malicious content scanner.
     */
    private function scanFileContent(UploadedFile $file): void
    {
        $content = file_get_contents($file->getRealPath());

        // Check for suspicious patterns
        $suspiciousPatterns = [
            '/<script/i',
            '/<iframe/i',
            '/eval\(/i',
            '/base64_decode/i',
            '/exec\(/i',
            '/system\(/i',
            '/passthru\(/i',
            '/shell_exec/i',
            '/<?php/i',
            '/<\?=/i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                throw new \Exception('Suspicious content detected in file');
            }
        }
    }

    /**
     * Delete file securely.
     */
    public function deleteFile(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Validate file by path.
     */
    public function validateFilePath(string $path): bool
    {
        // Prevent directory traversal
        if (strpos($path, '..') !== false) {
            return false;
        }

        // Only allow files in specific directories
        $allowedPaths = ['images/', 'documents/', 'uploads/'];

        $isAllowed = false;
        foreach ($allowedPaths as $allowedPath) {
            if (str_starts_with($path, $allowedPath)) {
                $isAllowed = true;
                break;
            }
        }

        return $isAllowed && Storage::disk('public')->exists($path);
    }
}
