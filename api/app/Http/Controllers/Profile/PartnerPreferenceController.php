<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PartnerPreference;
use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;

class PartnerPreferenceController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = PartnerPreference::class;

        $this->middleware(function ($request, $next) {
            $this->service = new BaseService(
                new BaseRepository(new PartnerPreference(), null)
            );
            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'age' => 'nullable|integer',
            'height' => 'nullable|integer',
            'preferred_age_min' => 'nullable|integer|min:18',
            'preferred_age_max' => 'nullable|integer|min:18',
            'preferred_height_min' => 'nullable|integer|min:50',
            'preferred_height_max' => 'nullable|integer|min:50',
            'marital_status' => 'nullable|in:divorced,separated,widowed,never_married',
            'children_acceptables' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:100',
            'caste' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:150',
            'occupation' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
            'horoscope_required' => 'boolean',
            'family_type' => 'nullable|in:joint,nuclear',
            'horoscope_natchathiram' => 'nullable|string|max:150',
            'horoscope_rasi' => 'nullable|string|max:100',
            'dosham' => 'nullable|string|max:100',
            'type_of_dosham' => 'nullable|string|max:150',
            'other_dosham' => 'nullable|string|max:150',
            'drinking' => 'nullable|string|max:50',
            'smoking' => 'nullable|string|max:50',
            'profession' => 'nullable|string|max:150',
            'body_type' => 'nullable|string|max:100',
            'expectations' => 'nullable|string',
            'weight' => 'nullable|integer|min:1',
            'physical_status' => 'nullable|string|max:100',

        ];

        $this->updateRules = $this->storeRules;
        unset($this->updateRules['profile_id']); // profile_id usually shouldn't change on update
    }

    // List all partner preferences (optionally by profile)
    public function index(Request $request)
    {
        try {
            $this->authorize('view', $this->policyModel);
            $filters = [];
            if ($request->has('profile_id')) {
                $filters['profile_id'] = $request->profile_id;
            }

            $data = $this->service->list($filters);

            return ApiResponse::success('Partner preferences fetched successfully', $data);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch partner preferences', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    // Show a single partner preference
    public function show($id, Request $request)
    {
        try {
            $partnerPreference = PartnerPreference::findOrFail($id);
            $this->authorize('view', $partnerPreference);

            $data = $this->service->get($id, $request->get('with', []));

            return ApiResponse::success('Record found', $data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Partner preference not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch partner preference', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    // Store a new partner preference
    public function store(Request $request)
    {
        try {
            // $this->authorize('create', $this->policyModel);
            $validatedData = $request->validate($this->storeRules);

            Log::info('Creating partner preference', [
                'user_id' => Auth::id(),
                'data' => $validatedData,
            ]);

            $partnerPreference = $this->service->create($validatedData);

            return ApiResponse::success('Partner preference created successfully', $partnerPreference);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Failed to create partner preference', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to create', $e->getMessage(), 500);
        }
    }

    // Update an existing partner preference
    public function update(Request $request, $id)
    {
        try {
            $partnerPreference = PartnerPreference::where('profile_id', $id)->firstOrFail();
            // $this->authorize('update', $partnerPreference);

            $validatedData = $request->validate($this->updateRules);

            Log::info('Updating partner preference', [
                'user_id' => Auth::id(),
                'partner_preference_id' => $id,
                'data' => $validatedData,
            ]);

            $partnerPreference = $this->service->update($partnerPreference->id, $validatedData);

            return ApiResponse::success('Partner preference updated successfully', $partnerPreference);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Failed to update partner preference', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to update', $e->getMessage(), 500);
        }
    }

    // Delete a partner preference
    public function destroy($id)
    {
        try {
            $partnerPreference = PartnerPreference::findOrFail($id);
            $this->authorize('delete', $partnerPreference);

            $this->service->delete($id);

            return ApiResponse::success('Partner preference deleted successfully');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Partner preference not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to delete partner preference', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to delete', $e->getMessage(), 500);
        }
    }
}