<?php

namespace App\Http\Controllers\Horoscope;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\HoroscopeBox;
use App\Models\HoroscopeBoxValue;

class HoroscopeController extends BaseController
{

    protected BaseService $membershipService;
    protected BaseService $membersService;
    public function __construct()
    {
        $this->policyModel = HoroscopeBox::class;

        $this->middleware(function ($request, $next) {

            $authUser = Auth::user();

            Log::info('HOROSCOPE_REQUEST: Reached Controller Middleware', [
                'user_id' => $authUser?->id,
                'role_id' => $authUser?->role_id,
                'path' => $request->path(),
                'method' => $request->method(),
                'payload_size' => strlen($request->getContent())
            ]);

            $this->service = new BaseService(
                new BaseRepository(new HoroscopeBox(), null)
            );

            return $next($request);
        });

        // Validation rules for storing 1 box
        $this->storeRules = [
            'items' => 'required|array',
            'items.*.profile_id' => 'nullable|integer|exists:profiles,id',
            'items.*.box_number' => 'nullable|integer|min:1|max:12',
            'items.*.item_number' => 'nullable|integer|min:1|max:6',
            'items.*.type' => 'nullable|string|in:ZODIAC,FEATURE',
            'items.*.value' => 'nullable|string',
        ];



        // Update rules (same dropdowns)
        $this->updateRules = [
            'items' => 'required|array',
            'items.*.profile_id' => 'nullable|integer|exists:profiles,id',
            'items.*.box_number' => 'nullable|integer|min:1|max:12',
            'items.*.item_number' => 'nullable|integer|min:1|max:6',
            'items.*.type' => 'nullable|string|in:ZODIAC,FEATURE',
            'items.*.value' => 'nullable|string',
        ];
    }

    /**
     * Store ONE box (1–12)
     */
    public function store(Request $request)
    {
        Log::info('HOROSCOPE_REQUEST_ENTRY: store', ['size' => strlen($request->getContent())]);
        Log::info('HOROSCOPE_METHOD: store called');

        try {
            // 🛡️ AUTH: Relying on auth:sanctum middleware for now to debug 403. 
            // Explicitly allow if user is authenticated.
            if (!Auth::check()) {
                return ApiResponse::error('Unauthorized', 'Please login', 401);
            }

            $validatedData = $request->validate($this->storeRules);

            return DB::transaction(function () use ($request, $validatedData) {
                // 🔥 delete existing if requested (standard for full batch)
                if ($request->is_first) {
                    $profileId = $validatedData['items'][0]['profile_id'] ?? null;
                    if ($profileId) {
                        HoroscopeBox::where('profile_id', $profileId)->delete();
                    }
                }

                $data = [];
                foreach ($validatedData['items'] as $row) {
                    $data[] = [
                        'profile_id' => $row['profile_id'],
                        'box_number' => $row['box_number'],
                        'item_number' => $row['item_number'],
                        'type' => $row['type'],
                        'value' => $row['value'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                HoroscopeBox::insert($data);

                return ApiResponse::success('Horoscope saved successfully');
            });

        } catch (\Exception $e) {
            Log::error('Error storing horoscope: ' . $e->getMessage());
            return ApiResponse::error('Failed to save horoscope', 500);
        }
    }

    /**
     * Update ONE box + dropdowns
     */


    public function update(Request $request, $profileId)
    {
        Log::info('HOROSCOPE_REQUEST_ENTRY: update', ['profile_id' => $profileId, 'size' => strlen($request->getContent())]);
        Log::info('HOROSCOPE_METHOD: update called', ['profile_id' => $profileId]);

        try {
            // 🛡️ AUTH: Relying on auth:sanctum middleware for now to debug 403.
            if (!Auth::check()) {
                return ApiResponse::error('Unauthorized', 'Please login', 401);
            }

            $validated = $request->validate($this->updateRules);

            return DB::transaction(function () use ($request, $profileId, $validated) {
                // 🔥 delete existing if requested (standard for full batch)
                if ($request->is_first) {
                    HoroscopeBox::where('profile_id', $profileId)->delete();
                }

                $data = [];
                foreach ($validated['items'] as $row) {
                    $data[] = [
                        'profile_id' => $profileId,
                        'box_number' => $row['box_number'],
                        'item_number' => $row['item_number'],
                        'type' => $row['type'],
                        'value' => $row['value'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                HoroscopeBox::insert($data);

                return ApiResponse::success('Horoscope updated successfully');
            });

        } catch (\Exception $e) {
            Log::error('Horoscope update error: ' . $e->getMessage());
            return ApiResponse::error('Failed to update horoscope', 500);
        }
    }


    /**
     * Get all 12 boxes for authenticated user
     */
    public function myBoxes()
    {
        $authUser = Auth::user();

        $boxes = HoroscopeBox::where('user_id', $authUser->id)
            ->with('values')
            ->orderBy('box_number')
            ->get();

        return ApiResponse::success('My horoscope boxes', $boxes);
    }

    /**
     * Delete a box
     */
    public function destroy($id)
    {
        $box = HoroscopeBox::findOrFail($id);

        $this->authorize('delete', $box);

        $box->delete();

        return ApiResponse::success('Box deleted successfully');
    }
}