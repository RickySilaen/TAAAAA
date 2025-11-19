<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Base Data Transfer Object.
 *
 * Provides immutable data containers for transferring data between layers.
 * Enforces type safety and validation at the boundary between layers.
 */
abstract class BaseDTO implements Arrayable, JsonSerializable
{
    /**
     * Create DTO from array.
     */
    public static function fromArray(array $data): static
    {
        $reflection = new \ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();

        if (! $constructor) {
            return new static();
        }

        $parameters = $constructor->getParameters();
        $args = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $snakeName = Str::snake($name);

            // Try both camelCase and snake_case
            $value = $data[$name] ?? $data[$snakeName] ?? null;

            // Handle default values
            if ($value === null && $parameter->isDefaultValueAvailable()) {
                $value = $parameter->getDefaultValue();
            }

            $args[] = $value;
        }

        return new static(...$args);
    }

    /**
     * Create DTO from request.
     */
    public static function fromRequest(\Illuminate\Http\Request $request): static
    {
        return static::fromArray($request->all());
    }

    /**
     * Create DTO from model.
     */
    public static function fromModel(\Illuminate\Database\Eloquent\Model $model): static
    {
        return static::fromArray($model->toArray());
    }

    /**
     * Convert DTO to array.
     */
    public function toArray(): array
    {
        $array = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            $array[Str::snake($name)] = $this->$name;
        }

        return $array;
    }

    /**
     * Convert DTO to JSON.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Validate required fields.
     *
     *
     * @throws \InvalidArgumentException
     */
    protected function validateRequired(array $required): void
    {
        $array = $this->toArray();
        $missing = [];

        foreach ($required as $field) {
            if (! isset($array[$field]) || $array[$field] === null || $array[$field] === '') {
                $missing[] = $field;
            }
        }

        if (! empty($missing)) {
            throw new \InvalidArgumentException(
                'Missing required fields: ' . implode(', ', $missing)
            );
        }
    }

    /**
     * Validate field types.
     *
     *
     * @throws \InvalidArgumentException
     */
    protected function validateTypes(array $types): void
    {
        $array = $this->toArray();

        foreach ($types as $field => $expectedType) {
            if (! isset($array[$field])) {
                continue;
            }

            $value = $array[$field];
            $actualType = gettype($value);

            if ($actualType !== $expectedType && ! $value instanceof $expectedType) {
                throw new \InvalidArgumentException(
                    "Field '{$field}' must be of type {$expectedType}, {$actualType} given"
                );
            }
        }
    }

    /**
     * Get only non-null values.
     */
    public function toArrayWithoutNulls(): array
    {
        return array_filter($this->toArray(), fn ($value) => $value !== null);
    }

    /**
     * Merge with another array.
     */
    public function mergeWith(array $data): array
    {
        return array_merge($this->toArray(), $data);
    }

    /**
     * Get specific fields only.
     */
    public function only(array $fields): array
    {
        $array = $this->toArray();

        return array_intersect_key($array, array_flip($fields));
    }

    /**
     * Get all fields except specified.
     */
    public function except(array $fields): array
    {
        $array = $this->toArray();

        return array_diff_key($array, array_flip($fields));
    }
}
