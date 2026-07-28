<?php

namespace App\Services;

use App\Models\Member;
use App\Repositories\ProfileCompletionRepository;

class ProfileCompletionService
{
    public function __construct(
        private readonly ProfileCompletionRepository $repository
    ) {
    }

    public function recalculateMemberCompletion(int $memberId): ?array
    {
        $member = $this->repository->getMemberWithRelations($memberId);

        if (!$member) {
            return null;
        }

        $completion = $this->calculateCompletion($member);

        $this->repository->updateProfileCompleteFlag($member->id, $completion['is_profile_complete']);

        return $completion;
    }

    public function getIncompleteMembers(int $perPage = 10, array $filters = []): array
    {
        $paginator = $this->repository->getIncompleteMembers($perPage, $filters);

        $rows = collect($paginator->items())->map(function (Member $member) {
            $completion = $this->calculateCompletion($member);

            return [
                'id' => $member->id,
                'profile_id' => $member->profile?->id,
                'member_no' => $member->member_no,
                'user_name' => $member->profile?->user?->name,
                'phone' => $member->profile?->user?->phone,
                'profile_photo' => $member->profile?->profile_photo
                    ?: (strtolower((string) $member->profile?->gender) === 'female'
                        ? 'storage/default_image/default_female.jpg'
                        : 'storage/default_image/default_male.jpg'),
                'membership_slug' => $member->membership?->slug,
                'status' => $member->status,
                'created_at' => optional($member->created_at)->format('d-m-Y h:i A'),
                'is_profile_complete' => false,
                'profile_completion_badge' => 'Incomplete Profile',
                'completion_percentage' => $completion['completion_percentage'],
                'missing_fields' => $completion['missing_fields'],
                'missing_fields_text' => implode(', ', $completion['missing_fields']),
            ];
        })->values();

        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
            'data' => $rows,
        ];
    }

    public function calculateCompletion(Member $member): array
    {
        $requiredFields = config('profile_completion.required_fields', []);
        $fieldLabels = config('profile_completion.field_labels', []);

        $profile = $member->profile;
        $familyDetail = $profile?->familyDetail;
        $partnerPreference = $profile?->partnerPreference;

        $missingFields = [];
        $totalRequired = 0;

        foreach (($requiredFields['profile'] ?? []) as $field) {
            $totalRequired++;
            if (!$this->isFilled($profile?->{$field} ?? null)) {
                $missingFields[] = $fieldLabels[$field] ?? $field;
            }
        }

        foreach (($requiredFields['family_detail'] ?? []) as $field) {
            $totalRequired++;
            if (!$this->isFilled($familyDetail?->{$field} ?? null)) {
                $missingFields[] = $fieldLabels[$field] ?? $field;
            }
        }

        foreach (($requiredFields['partner_preference'] ?? []) as $field) {
            $totalRequired++;
            if (!$this->isFilled($partnerPreference?->{$field} ?? null)) {
                $missingFields[] = $fieldLabels[$field] ?? $field;
            }
        }

        $missingCount = count($missingFields);
        $filledCount = max(0, $totalRequired - $missingCount);
        $completionPercentage = $totalRequired > 0
            ? (int) round(($filledCount / $totalRequired) * 100)
            : 0;

        return [
            'is_profile_complete' => $missingCount === 0,
            'completion_percentage' => $completionPercentage,
            'missing_fields' => $missingFields,
        ];
    }

    private function isFilled(mixed $value): bool
    {
        if (is_null($value)) {
            return false;
        }

        if (is_string($value)) {
            return trim($value) !== '';
        }

        if (is_array($value)) {
            return count($value) > 0;
        }

        return true;
    }
}
