<?php

namespace Bits\Package\Services\RBAC;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class PermissionService
{
    protected Model $model;

    /**
     * @param Model $model The Permission model instance
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all permissions
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get permission by ID
     *
     * @param int|string $id
     * @return Model|null
     */
    public function getPermissionById($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Get permissions grouped by module
     *
     * @return Collection
     */
    public function getPermissionsGroupedByModule(): Collection
    {
        return $this->model->all()->groupBy('module');
    }

    /**
     * Get permissions for a specific module
     *
     * @param string $module
     * @return Collection
     */
    public function getPermissionsByModule(string $module): Collection
    {
        return $this->model->where('module', $module)->get();
    }

    /**
     * Create a new permission
     *
     * @param array $data
     * @return Model
     */
    public function createPermission(array $data): Model
    {
        return $this->model->create($data);
    }
}
