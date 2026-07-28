<?php

namespace App\Http\Controllers\Activity;


use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use App\Models\MemberActivity;

class MemberActivityController extends BaseController
{

    public function __construct()
    {
        $this->policyModel = MemberActivity::class;

        $this->middleware(function ($request, $next) {

            // No tenant_id in memberships → pass null 
            $this->service = new BaseService(
                new BaseRepository(new MemberActivity(), null)
            );

            return $next($request);
        });



        // Validation rules for creating a profile
        $this->storeRules = [
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'activity_type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ];

        $this->updateRules = [
            'member_id' => 'sometimes|exists:members,id',
            'name' => 'sometimes|string|max:255',
            'mobile' => 'sometimes|string|max:20',
            'activity_type' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ];
    }
}