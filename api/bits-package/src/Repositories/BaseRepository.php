<?php

namespace Bits\Package\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class BaseRepository
{
    protected Model $model;
    protected ?int $tenantId;

    public function __construct(Model $model, ?int $tenantId = null)
    {
        $this->model = $model;
        $this->tenantId = $tenantId;
    }

    public function setTenantId(?int $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    protected function isTenantScoped(): bool
    {
        // Check if model has $isTenantScoped property set to true
        // or if it has tenant_id in its fillable or table columns
        // For safety, we'll check for a property or trait later, but for now
        // let's stick to a property check if available, or just use the current logic
        // but refined.
        if (isset($this->model->isTenantScoped) && $this->model->isTenantScoped === false) {
            return false;
        }

        return $this->tenantId !== null;
    }

    public function all(array $filters = [], array $joins = [], array $with = [], array $orderBy = [])
    {
        $query = $this->model->newQuery();

        // tenant scope apply only if tenantId is set
        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        $query = $this->applyJoins($query, $joins);
        $query = $this->applyFilters($query, $filters);

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        return $query->get();
    }

    public function find($idOrFilters, array $with = [], array $select = [])
    {
        $query = $this->model->newQuery();

        // Tenant scope
        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        // If $idOrFilters is integer/string, treat as ID
        if (is_int($idOrFilters) || is_string($idOrFilters)) {
            $query->where('id', $idOrFilters);
        }
        // If array, treat as filters
        elseif (is_array($idOrFilters)) {
            $query = $this->applyFilters($query, $idOrFilters);
        }

        // Select specific columns if provided
        if (!empty($select)) {
            $query->select($select);
        }

        // Eager load relations if provided
        if (!empty($with)) {
            $query->with($with);
        }

        $model = $query->first();

        if (!$model) {
            throw (new ModelNotFoundException)
                ->setModel(get_class($this->model), is_array($idOrFilters) ? json_encode($idOrFilters) : $idOrFilters);
        }

        return $model;
    }


    public function create(array $data)
    {
        if ($this->isTenantScoped()) {
            $data['tenant_id'] = $this->tenantId;
        }
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id): bool
    {
        $model = $this->find($id);
        return $model->delete();
    }

    public function bulkInsert(array $data)
    {
        $now = now();

        foreach ($data as &$item) {
            // Add tenant_id only if tenantId is set (SaaS mode)
            if ($this->isTenantScoped()) {
                $item['tenant_id'] = $this->tenantId;
            }

            // Add timestamps if the model uses them
            if ($this->model->usesTimestamps()) {
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
            }
        }
        unset($item); // prevent reference issues

        return $this->model->insert($data);
    }


    public function bulkUpdate(array $data, string $key = 'id')
    {
        $updated = [];

        foreach ($data as $row) {
            // Find model (multi-tenant safe)
            $query = $this->model->where($key, $row[$key]);

            if ($this->isTenantScoped()) {
                $query->where('tenant_id', $this->tenantId);
            }

            $model = $query->first();

            if ($model) {
                // Remove key so it's not accidentally mass-assigned
                $updateData = Arr::except($row, [$key]);

                // Apply update
                $model->fill($updateData);

                // Eloquent handles timestamps automatically
                $model->save();

                $updated[] = $model;
            }
        }

        return $updated;
    }

    public function query(array $filters = [], array $joins = [], array $with = [], array $orderBy = []): Builder
    {
        $query = $this->model->newQuery();

        // tenant scope
        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        $query = $this->applyJoins($query, $joins);
        $query = $this->applyFilters($query, $filters);

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }

        return $query; // <- return query builder, not Collection
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, array $filters = [], array $joins = [], array $with = [], array $orderBy = [])
    {
        return $this->query($filters, $joins, $with, $orderBy)->paginate($perPage);
    }


    public function bulkDelete(array $ids)
    {
        $query = $this->model->whereIn('id', $ids);

        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        return $query->delete();
    }

    public function deleteWhere(array $conditions)
    {
        $query = $this->model->where($conditions);

        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        return $query->delete();
    }


    public function count(array $filters = []): int
    {
        $query = $this->model->newQuery();

        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        $query = $this->applyFilters($query, $filters);

        return $query->count();
    }

    public function sum(string $column, array $filters = []): float
    {
        $query = $this->model->newQuery();

        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        $query = $this->applyFilters($query, $filters);

        return (float) $query->sum($column);
    }


    protected function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $filter) {

            // BETWEEN support
            if (is_array($filter) && isset($filter[0]) && strtolower($filter[0]) === 'between') {
                $query->whereBetween($key, $filter[1]);
                continue;
            }


            // Handle array-of-arrays format: [['column', 'operator', 'value']]
            if (is_array($filter) && count($filter) === 3) {
                [$column, $operator, $value] = $filter;
                $query->where($column, $operator, $value);
            }
            // Handle associative array format: ['column' => 'value']
            elseif (!is_array($filter)) {
                $query->where($key, '=', $filter);
            }
            // Handle ['column' => ['operator', 'value']]
            elseif (is_array($filter) && count($filter) === 2 && isset($filter[0], $filter[1])) {
                $query->where($key, $filter[0], $filter[1]);
            }
        }

        return $query;
    }


    protected function applyJoins(Builder $query, array $joins): Builder
    {
        foreach ($joins as $join) {
            $query->join(...$join);
        }
        return $query;
    }

    public function aggregate(array $selectRaw, array $filters = [], array $groupBy = [], array $orderBy = [])
    {
        $query = $this->model->newQuery();

        if ($this->isTenantScoped()) {
            $query->where($this->model->getTable() . '.tenant_id', $this->tenantId);
        }

        if (!empty($filters)) {
            $query = $this->applyFilters($query, $filters);
        }

        if (!empty($selectRaw)) {
            $query->selectRaw(implode(', ', $selectRaw));
        }

        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $col => $dir) {
                $query->orderBy($col, $dir);
            }
        }

        return $query->get();
    }
}
