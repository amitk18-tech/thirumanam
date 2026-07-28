<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\PhysicalAttribute;

class PhysicalAttributeController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = PhysicalAttribute::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();
            Log::info('PHYSICAL_ATTRIBUTE_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new PhysicalAttribute(), null)
            );

            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'height' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'complexion' => 'nullable|string',
            'body_type' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'physical_status' => 'nullable|string',
            'eye_color' => 'nullable|string',
            'hair_color' => 'nullable|string',
        ];

        $this->updateRules = $this->storeRules;
    }

    public function store(Request $request)
    {
        // $this->authorize('create', PhysicalAttribute::class);
        $validated = $request->validate($this->storeRules);
        $attribute = $this->service->create($validated);
        return ApiResponse::success('Physical attribute created', $attribute);
    }

    public function update(Request $request, $id)
    {
        $attribute = PhysicalAttribute::findOrFail($id);
        // $this->authorize('update', $attribute);
        $validated = $request->validate($this->updateRules);
        $attribute->update($validated);
        return ApiResponse::success('Physical attribute updated', $attribute);
    }

    public function byProfile($profileId)
    {
        $attribute = PhysicalAttribute::where('profile_id', $profileId)->first();
        return ApiResponse::success('Physical attribute', $attribute);
    }

    public function destroy($id)
    {
        $attribute = PhysicalAttribute::findOrFail($id);
        $this->authorize('delete', $attribute);
        $attribute->delete();
        return ApiResponse::success('Physical attribute deleted');
    }
}