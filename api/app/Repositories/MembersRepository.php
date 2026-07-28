<?php

namespace App\Repositories;

use App\Models\Member;
use Bits\Package\Repositories\BaseRepository;


class MembersRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Member());
    }


    // get active members
    public function getActiveMembers()
    {
        return Member::active()->get();
    }

    // expired members
    public function getExpiredMembers()
    {
        return Member::expired()->get();
    }

    // members whose membership is expiring in next 7 days
    public function getMembersExpiringSoon($days = 7)
    {
        return Member::expiringSoon($days)->get();
    }

    // members with auto renewal enabled
    public function getAutoRenewalMembers()
    {
        return Member::autoRenewal()->get();
    }

    // Cancel a member's membership
    public function cancelledMembers()
    {
        return Member::cancelled()->get();
    }
}