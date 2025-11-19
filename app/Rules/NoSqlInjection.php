<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * SQL Injection Protection Rule
 * Validates input against SQL injection patterns.
 */
class NoSqlInjection implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            return;
        }

        // SQL injection patterns
        $sqlPatterns = [
            '/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|EXECUTE|UNION|DECLARE)\b)/i',
            '/(\b(OR|AND)\b.*=.*)/i',
            '/(--|#|\/\*|\*\/)/i',
            '/(\bxp_\w+\b)/i',
            '/(\bsp_\w+\b)/i',
            '/(;\s*(DROP|DELETE|UPDATE|INSERT))/i',
            '/(\')(.*)(--)/i',
            '/(\')(.*)(;)/i',
            '/(CONCAT\s*\()/i',
            '/(CHAR\s*\()/i',
            '/(0x[0-9a-f]+)/i',
        ];

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                $fail('The :attribute contains suspicious content.');

                return;
            }
        }
    }
}
