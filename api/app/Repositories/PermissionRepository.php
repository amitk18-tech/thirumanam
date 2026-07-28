<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Permission;

class PermissionRepository
{
    protected $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }


    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}