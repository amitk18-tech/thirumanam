<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Address;

class AddressController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Address::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();
            Log::info('ADDRESS_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new Address(), null)
            );

            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'native_place' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'mobile' => 'nullable|string',
            'alternate_number' => 'nullable|string',
            'landline' => 'nullable|string',
            'current_city' => 'nullable|string',
        ];

        $this->updateRules = $this->storeRules;
    }

    public function store(Request $request)
    {
        // $this->authorize('create', Address::class);
        $validated = $request->validate($this->storeRules);
        $address = $this->service->create($validated);
        return ApiResponse::success('Address created', $address);
    }

    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);
        // $this->authorize('update', $address);
        $validated = $request->validate($this->updateRules);
        $address->update($validated);
        return ApiResponse::success('Address updated', $address);
    }

    public function byProfile($profileId)
    {
        $address = Address::where('profile_id', $profileId)->first();
        return ApiResponse::success('Address', $address);
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $this->authorize('delete', $address);
        $address->delete();
        return ApiResponse::success('Address deleted');
    }
}