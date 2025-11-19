<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Base Repository Pattern Interface Implementation.
 *
 * Provides common CRUD operations and query methods for all repositories.
 * Reduces code duplication and enforces consistent data access patterns.
 */
abstract class BaseRepository
{
    /**
     * The model instance.
     */
    protected Model $model;

    /**
     * Get all records.
     */
    public function all(array $columns = ['*'], array $with = []): Collection
    {
        return $this->query()
            ->with($with)
            ->get($columns);
    }

    /**
     * Find a record by ID.
     */
    public function find(int $id, array $columns = ['*'], array $with = []): ?Model
    {
        return $this->query()
            ->with($with)
            ->find($id, $columns);
    }

    /**
     * Find a record by ID or fail.
     *
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id, array $columns = ['*'], array $with = []): Model
    {
        return $this->query()
            ->with($with)
            ->findOrFail($id, $columns);
    }

    /**
     * Find a record by specific column.
     *
     * @param  mixed  $value
     */
    public function findBy(string $column, $value, array $columns = ['*'], array $with = []): ?Model
    {
        return $this->query()
            ->with($with)
            ->where($column, $value)
            ->first($columns);
    }

    /**
     * Get all records matching criteria.
     */
    public function findWhere(array $criteria, array $columns = ['*'], array $with = []): Collection
    {
        $query = $this->query()->with($with);

        foreach ($criteria as $column => $value) {
            $query->where($column, $value);
        }

        return $query->get($columns);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record.
     */
    public function update(int $id, array $data): bool
    {
        $record = $this->findOrFail($id);

        return $record->update($data);
    }

    /**
     * Delete a record.
     */
    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        return $record->delete();
    }

    /**
     * Paginate records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $with = []): LengthAwarePaginator
    {
        return $this->query()
            ->with($with)
            ->paginate($perPage, $columns);
    }

    /**
     * Count records.
     */
    public function count(array $criteria = []): int
    {
        $query = $this->query();

        foreach ($criteria as $column => $value) {
            $query->where($column, $value);
        }

        return $query->count();
    }

    /**
     * Check if record exists.
     */
    public function exists(int $id): bool
    {
        return $this->query()->where('id', $id)->exists();
    }

    /**
     * Get latest records.
     */
    public function latest(int $limit = 10, array $columns = ['*'], array $with = []): Collection
    {
        return $this->query()
            ->with($with)
            ->latest()
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get oldest records.
     */
    public function oldest(int $limit = 10, array $columns = ['*'], array $with = []): Collection
    {
        return $this->query()
            ->with($with)
            ->oldest()
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get query builder instance.
     */
    protected function query(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the model instance.
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Set the model instance.
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }
}
