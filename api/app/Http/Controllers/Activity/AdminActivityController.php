<?php

namespace App\Http\Controllers\Activity;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use App\Models\AdminActivity;

class AdminActivityController extends BaseController
{

    public function __construct()
    {
        $this->policyModel = AdminActivity::class;

        $this->middleware(function ($request, $next) {
            $this->service = new BaseService(
                new BaseRepository(new AdminActivity(), null)
            );
            return $next($request);
        });

        // Validation rules for creating a profile
        $this->storeRules = [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'activity_type' => 'required|string|max:255',
            'member_activity' => 'nullable|string',
        ];

        $this->updateRules = [
            'user_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'mobile' => 'sometimes|string|max:20',
            'activity_type' => 'sometimes|string|max:255',
            'member_activity' => 'sometimes|string',
        ];
    }
}