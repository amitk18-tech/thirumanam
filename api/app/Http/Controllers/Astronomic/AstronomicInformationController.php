<?php

namespace App\Http\Controllers\Astronomic;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\AstronomicInformation;
use App\Models\Profile;

class AstronomicInformationController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = AstronomicInformation::class;

        $this->middleware(function ($request, $next) {

            $authUser = Auth::user();

            Log::info('ASTRONOMIC_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new AstronomicInformation(), null)
            );

            return $next($request);
        });

        // Validation rules
        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',

            'star' => 'nullable|string',
            'rasi' => 'nullable|string',
            'nakshatra' => 'nullable|string',
            'charan' => 'nullable|string',
            'padam' => 'nullable|string',
            'ganam' => 'nullable|string',
            'nadi' => 'nullable|string',
            'dosham' => 'nullable|string',
            'paksha' => 'nullable|string',
            'tithi' => 'nullable|string',
            'directional_balance' => 'nullable|string',
            'day_of_birth' => 'nullable|string',
            'birth_time' => 'nullable|string',
            'birth_place' => 'nullable|string',
            'birth_country' => 'nullable|string',
            'birth_state' => 'nullable|string',
            'birth_city' => 'nullable|string',
            'lakknam' => 'nullable|string',
            'horoscope_matching' => 'nullable|string',
        ];

        $this->updateRules = $this->storeRules;
    }

    /**
     * Create Astronomic Information
     */
    public function store(Request $request)
    {
        $this->authorize('create', AstronomicInformation::class);

        $validated = $request->validate($this->storeRules);

        $info = $this->service->create($validated);

        return ApiResponse::success('Astronomic information saved', $info);
    }

    /**
     * Update Astronomic Information
     */
    public function update(Request $request, $id)
    {
        $info = AstronomicInformation::findOrFail($id);

        $this->authorize('update', $info);

        $validated = $request->validate($this->updateRules);

        $info->update($validated);

        return ApiResponse::success('Astronomic information updated', $info);
    }

    /**
     * Get astronomic info for a profile
     */
    public function byProfile($profileId)
    {
        $authUser = Auth::user();

        // Optional: limit to user's own profile
        $profile = Profile::where('id', $profileId)
            ->where('user_id', $authUser->id)
            ->firstOrFail();

        $info = AstronomicInformation::where('profile_id', $profileId)->first();

        return ApiResponse::success('Astronomic information', $info);
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $info = AstronomicInformation::findOrFail($id);

        $this->authorize('delete', $info);

        $info->delete();

        return ApiResponse::success('Astronomic information deleted');
    }
}