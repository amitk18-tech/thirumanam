<?php

namespace App\Http\Controllers\Memberships;

use App\Http\Responses\ApiResponse;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;

class MembershipController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Membership::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('MEMBERSHIP: Authenticated User', [
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            // No tenant_id in memberships → pass null
            $this->service = new BaseService(
                new BaseRepository(new Membership(), null)
            );

            return $next($request);
        });

        // Validation rules for creating a membership
        $this->storeRules = [
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:150|unique:memberships,slug',

            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',

            // Limits
            'sent_Interested' => 'nullable|integer|min:0',
            'savaran_plan' => 'nullable|in:1_to_25,1_to_50,unlimited',
            'profiles_allowed' => 'nullable|integer|min:0',
            'messages_allowed' => 'nullable|integer|min:0',
            'contacts_allowed' => 'nullable|integer|min:0',
            'phone_numbers_allowed' => 'nullable|integer|min:0',
            'horoscopes_allowed' => 'nullable|integer|min:0',
            'photos_allowed' => 'nullable|integer|min:0',
            'personalized_assistance' => 'nullable|integer|min:0',
            'live_chat' => 'nullable|integer|min:0',

            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'in:active,expired,cancelled',
        ];


        // Validation rules for updating a membership
        $this->updateRules = [
            'name' => 'sometimes|required|string|max:100',
            'slug' => 'sometimes|required|string|max:150|unique:memberships,slug',
            'price' => 'sometimes|required|numeric|min:0',
            'duration_days' => 'sometimes|required|integer|min:1',

            // Limits
            'savaran_plan' => 'sometimes|required',
            'profiles_allowed' => 'sometimes|required|integer|min:0',
            'messages_allowed' => 'sometimes|required|integer|min:0',
            'contacts_allowed' => 'sometimes|required|integer|min:0',
            'phone_numbers_allowed' => 'sometimes|required|integer|min:0',
            'horoscopes_allowed' => 'sometimes|required|integer|min:0',
            'photos_allowed' => 'sometimes|required|integer|min:0',
            'personalized_assistance' => 'sometimes|required|integer|min:0',
            'live_chat' => 'sometimes|required|integer|min:0',

            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
            'status' => 'in:active,expired,cancelled',
        ];
    }
    public function publicIndex(Request $request)
    {
        try {
            $data = Membership::where('membership_mode', 'online')->where('status', 'active')->get();
            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    public function index(Request $request)
    {

        try {

            $this->authorize('viewAny', Membership::class);


            Log::info('ACTION: Fetching data', [
                'user_id' => Auth::id(),
                'tenant_id' => $this->policyModel,
                'filters' => $request->get('filters', []),
                'joins' => $request->get('joins', []),
                'with' => $request->get('with', [])
            ]);
            // $this->authorize('viewAny', $this->policyModel);
            $status = $request->get('status');

            $filter = [];
            if ($status) {
                $filter = ["status" => $status];
            }

            $data = $this->service->list(
                $filter,
                $request->get('joins', []),
                $request->get('with', [])
            );
            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Data not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }
}