<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\EducationCareer;

class EducationCareerController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = EducationCareer::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();
            Log::info('EDUCATION_CAREER_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new EducationCareer(), null)
            );

            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'education' => 'nullable|string',
            'occupation' => 'nullable|string',
            'income' => 'nullable|string',
            'work_location' => 'nullable|string',
            'study_details' => 'nullable|string',
            'career_profile' => 'nullable|string',
            'earnings' => 'nullable|in:daily,weekly,monthly',
            'income_amount' => 'nullable|numeric',
        ];

        $this->updateRules = $this->storeRules;
    }

    public function store(Request $request)
    {
        // $this->authorize('create', EducationCareer::class);
        $validated = $request->validate($this->storeRules);
        $educationCareer = $this->service->create($validated);
        return ApiResponse::success('Education & Career created', $educationCareer);
    }

    public function update(Request $request, $id)
    {
        $educationCareer = EducationCareer::findOrFail($id);
        // $this->authorize('update', $educationCareer);
        $validated = $request->validate($this->updateRules);
        $educationCareer->update($validated);
        return ApiResponse::success('Education & Career updated', $educationCareer);
    }

    public function byProfile($profileId)
    {
        $educationCareer = EducationCareer::where('profile_id', $profileId)->first();
        return ApiResponse::success('Education & Career', $educationCareer);
    }

    public function destroy($id)
    {
        $educationCareer = EducationCareer::findOrFail($id);
        $this->authorize('delete', $educationCareer);
        $educationCareer->delete();
        return ApiResponse::success('Education & Career deleted');
    }
}