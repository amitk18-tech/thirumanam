<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{

    private $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getAllPermissions()
    {
        return $this->repository->all();
    }

    public function getPermissionById($id)
    {
        return $this->repository->find($id);
    }
}