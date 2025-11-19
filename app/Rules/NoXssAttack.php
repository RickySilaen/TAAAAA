<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * XSS Attack Protection Rule
 * Validates input against XSS attack patterns.
 */
class NoXssAttack implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }

        // XSS attack patterns
        $xssPatterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '/<iframe\b[^>]*>(.*?)<\/iframe>/is',
            '/javascript:/i',
            '/on\w+\s*=\s*["\'].*?["\']/i',
            '/<embed\b[^>]*>/i',
            '/<object\b[^>]*>/i',
            '/<applet\b[^>]*>/i',
            '/<meta\b[^>]*>/i',
            '/<link\b[^>]*>/i',
            '/vbscript:/i',
            '/data:text\/html/i',
            '/onerror\s*=/i',
            '/onload\s*=/i',
            '/onclick\s*=/i',
            '/onmouseover\s*=/i',
            '/<svg\b[^>]*onload\s*=/i',
            '/eval\s*\(/i',
            '/expression\s*\(/i',
            '/alert\s*\(/i',
            '/prompt\s*\(/i',
            '/confirm\s*\(/i',
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $fail('The :attribute contains invalid characters or code.');

                return;
            }
        }
    }
}
