<?php

namespace App\Services;

use Bits\Package\Services\BaseService;
use App\Repositories\MembersRepository;

class MembersService extends BaseService
{

    protected MembersRepository $repository;

    public function __construct(MembersRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
    // Fetch active members
    public function getActiveMembers()
    {
        return $this->repository->getActiveMembers();
    }

    // Fetch expired members
    public function getExpiredMembers()
    {
        return $this->repository->getExpiredMembers();
    }

    // Fetch members whose membership is expiring in next given days (default 7 days)
    public function getMembersExpiringSoon($days = 7)
    {
        return $this->repository->getMembersExpiringSoon($days);
    }

    // Fetch members with auto renewal enabled
    public function getAutoRenewalMembers()
    {
        return $this->repository->getAutoRenewalMembers();
    }

    // Fetch cancelled members
    public function getCancelledMembers()
    {
        return $this->repository->cancelledMembers();
    }
}