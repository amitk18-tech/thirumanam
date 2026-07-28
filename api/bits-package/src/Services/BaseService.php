<?php

namespace Bits\Package\Services;

use Bits\Package\Repositories\BaseRepository;

class BaseService
{
    protected BaseRepository $repo;

    public function __construct(BaseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list(array $filters = [], array $joins = [], array $with = [], array $orderBy = [])
    {
        return $this->repo->all($filters, $joins, $with, $orderBy);
    }

    public function get($idOrFilters, array $with = [], array $select = [])
    {
        return $this->repo->find($idOrFilters, $with, $select);
    }

    public function create($data)
    {
        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function bulkInsert(array $data)
    {
        return $this->repo->bulkInsert($data);
    }

    public function query(array $filters = [], array $joins = [], array $with = [], array $orderBy = [])
    {
        return $this->repo->query($filters, $joins, $with, $orderBy);
    }

    public function bulkUpdate(array $data, string $key = 'id')
    {
        return $this->repo->bulkUpdate($data, $key);
    }

    public function bulkDelete(array $ids)
    {
        return $this->repo->bulkDelete($ids);
    }

    public function deleteWhere(array $conditions)
    {
        return $this->repo->deleteWhere($conditions);
    }

    public function sum(string $column, array $filters = []): float
    {
        return $this->repo->sum($column, $filters);
    }

    public function count(array $filters = []): int
    {
        return $this->repo->count($filters);
    }

    public function aggregate(array $selectRaw, array $filters = [], array $groupBy = [], array $orderBy = [])
    {
        return $this->repo->aggregate($selectRaw, $filters, $groupBy, $orderBy);
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, array $filters = [], array $joins = [], array $with = [], array $orderBy = [])
    {
        return $this->repo->paginate($perPage, $filters, $joins, $with, $orderBy);
    }

    // GETTERS : use this for accessing the repository directly and model scope methods
    public function repo(): BaseRepository
    {
        return $this->repo;
    }
}
