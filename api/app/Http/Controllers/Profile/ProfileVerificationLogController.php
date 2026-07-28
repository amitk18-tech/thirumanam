<?php

namespace App\Http\Controllers\Profile;


use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ProfileVerificationLog;

class ProfileVerificationLogController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = ProfileVerificationLog::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('PROFILE_VERIFICATION_LOG: Authenticated User', [
                'user_id'     => $authUser?->id,
                'role'        => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            // No tenant_id → pass null
            $this->service = new BaseService(
                new BaseRepository(new ProfileVerificationLog(), null)
            );

            return $next($request);
        });

        // Validation rules for creating a log
        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'admin_id'   => 'required|exists:users,id',
            'action'     => 'required|in:verify,block,delete,mark_fake',
            'reason'     => 'nullable|string',
        ];

        // Validation rules for updating a log
        $this->updateRules = [
            'action' => 'sometimes|required|in:verify,block,delete,mark_fake',
            'reason' => 'nullable|string',
        ];
    }
}