<?php

namespace App\Http\Controllers\Matches;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\MatchAction;
use App\Models\Profile;
use Bits\Package\Responses\ApiResponse;

class MatchActionController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = MatchAction::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('MATCH_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            $this->service = new BaseService(
                new BaseRepository(new MatchAction(), null)
            );

            return $next($request);
        });

        $this->storeRules = [
            'sender_profile_id' => 'required|exists:profiles,id',
            'receiver_profile_id' => 'required|exists:profiles,id|different:sender_profile_id',
            'action_type' => 'required|in:interest_sent,accepted,declined,liked,shortlisted,blocked,contacted',
            'notes' => 'nullable|string',
        ];

        $this->updateRules = [
            'action_type' => 'sometimes|required|in:interest_sent,accepted,declined,liked,shortlisted,blocked,contacted',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Generic store
     */
    public function store(Request $request)
    {
        $this->authorize('create', MatchAction::class);

        $validatedData = $request->validate($this->storeRules);

        $matchaction = $this->service->create($validatedData);

        return ApiResponse::success('Match action created', $matchaction);
    }

    /**
     * Quick action: send interest
     */
    public function sendInterest(Request $request, $receiverId)
    {
        return $this->createAction($request, $receiverId, 'interest_sent');
    }

    /**
     * Quick action: like
     */
    public function like(Request $request, $receiverId)
    {
        return $this->createAction($request, $receiverId, 'liked');
    }

    /**
     * Quick action: shortlist
     */
    public function shortlist(Request $request, $receiverId)
    {
        return $this->createAction($request, $receiverId, 'shortlisted');
    }

    /**
     * Internal helper to create a match action
     */
    protected function createAction(Request $request, $receiverId, string $actionType)
    {
        $authUser = Auth::user();
        $senderProfile = Profile::where('user_id', $authUser->id)->first();

        if (!$senderProfile) {
            return ApiResponse::error('Profile not found for user', 404);
        }

        // Avoid duplicates (optional, if you want unique per pair+action)
        $exists = MatchAction::where([
            'sender_profile_id' => $senderProfile->id,
            'receiver_profile_id' => $receiverId,
            'action_type' => $actionType,
        ])->first();

        if ($exists) {
            return ApiResponse::error("You already performed this action", 400);
        }

        $matchAction = MatchAction::create([
            'sender_profile_id' => $senderProfile->id,
            'receiver_profile_id' => $receiverId,
            'action_type' => $actionType,
            'notes' => $request->input('notes'),
        ]);

        return ApiResponse::success(ucfirst($actionType) . ' action recorded', $matchAction);
    }
}