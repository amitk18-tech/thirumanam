<?php

namespace App\Repositories;

use App\Models\Member;
use Bits\Package\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfileCompletionRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Member());
    }

    public function getMemberWithRelations(int $memberId): ?Member
    {
        return Member::with([
            'profile.user',
            'profile.familyDetail',
            'profile.partnerPreference',
        ])->find($memberId);
    }

    public function updateProfileCompleteFlag(int $memberId, bool $isProfileComplete): int
    {
        return Member::where('id', $memberId)->update([
            'is_profile_complete' => $isProfileComplete,
            'updated_at' => now(),
        ]);
    }

    public function getIncompleteMembers(int $perPage, array $filters = []): LengthAwarePaginator
    {
        $query = Member::query()
            ->with([
                'profile.user',
                'profile.familyDetail',
                'profile.partnerPreference',
                'membership',
            ])
            ->where('is_profile_complete', false)
            ->latest('id');

        if (!empty($filters['member_no'])) {
            $query->where('member_no', 'like', '%' . $filters['member_no'] . '%');
        }

        if (!empty($filters['user_name'])) {
            $query->whereHas('profile.user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user_name'] . '%');
            });
        }

        if (!empty($filters['phone'])) {
            $query->whereHas('profile.user', function ($q) use ($filters) {
                $q->where('phone', 'like', '%' . $filters['phone'] . '%');
            });
        }

        return $query->paginate($perPage);
    }
}
