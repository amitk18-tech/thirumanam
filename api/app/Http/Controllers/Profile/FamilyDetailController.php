<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\FamilyDetail;
use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;

class FamilyDetailController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = FamilyDetail::class;

        $this->middleware(function ($request, $next) {
            $this->service = new BaseService(
                new BaseRepository(new FamilyDetail(), null)
            );
            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'surname' => 'nullable|string|max:100',
            'soveran_name' => 'nullable|string|max:100',
            'father_name' => 'nullable|string|max:100',
            'father_occupation' => 'nullable|string|max:150',
            'mother_name' => 'nullable|string|max:100',
            'mother_occupation' => 'nullable|string|max:150',
            'soveran_details' => 'nullable|integer',
            'father_vangusam' => 'nullable|string|max:100',
            'mother_vangusam' => 'nullable|string|max:100',
            'brothers_count' => 'nullable|integer|min:0',
            'brothers_married' => 'nullable|integer|min:0',
            'sisters_count' => 'nullable|integer|min:0',
            'sisters_married' => 'nullable|integer|min:0',
            'family_status' => 'nullable|in:middle class,upper,rich',
            'family_type' => 'nullable|in:joint,nuclear',
            'family_values' => 'nullable|in:traditional,modern',
            'about_family' => 'nullable|string',
            'property_description' => 'nullable|string',
            'year' => 'nullable|string',
            'month' => 'nullable|string',
            'day' => 'nullable|string',
        ];

        $this->updateRules = [
            'surname' => 'nullable|string|max:100',
            'father_name' => 'nullable|string|max:100',
            'father_occupation' => 'nullable|string|max:150',
            'mother_name' => 'nullable|string|max:100',
            'soveran_details' => 'nullable|min:0',
            'mother_occupation' => 'nullable|string|max:150',
            'father_vangusam' => 'nullable|string|max:100',
            'mother_vangusam' => 'nullable|string|max:100',
            'brothers_count' => 'nullable|integer|min:0',
            'brothers_married' => 'nullable|integer|min:0',
            'sisters_count' => 'nullable|integer|min:0',
            'sisters_married' => 'nullable|integer|min:0',
            'family_status' => 'nullable|in:middle class,upper,rich',
            'family_type' => 'nullable|in:joint,nuclear',
            'family_values' => 'nullable|in:traditional,modern',
            'about_family' => 'nullable|string',
            'property_description' => 'nullable|string',
            'year' => 'nullable|string',
            'month' => 'nullable|string',
            'day' => 'nullable|string',
        ];
    }

    // List all family details (optionally by profile)
    public function index(Request $request)
    {
        try {
            $filters = [];
            if ($request->has('profile_id')) {
                $filters['profile_id'] = $request->profile_id;
            }

            $data = $this->service->list($filters);

            return ApiResponse::success('Family details fetched successfully', $data);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch family details', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    // Show a single family detail
    public function show($id, Request $request)
    {
        try {
            $familyDetail = FamilyDetail::findOrFail($id);
            $this->authorize('view', $familyDetail);

            return ApiResponse::success('Record found', $familyDetail);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Family detail not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch family detail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    // Store a new family detail
    public function store(Request $request)
    {
        try {
            // $this->authorize('create', $this->policyModel);
            $validatedData = $request->validate($this->storeRules);

            Log::info('Creating family detail', [
                'user_id' => Auth::id(),
                'data' => $validatedData,
            ]);

            $familyDetail = $this->service->create($validatedData);

            return ApiResponse::success('Family detail created successfully', $familyDetail);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Failed to create family detail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to create', $e->getMessage(), 500);
        }
    }

    // Update an existing family detail
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->updateRules);

            Log::info('Updating family detail', [
                'user_id' => Auth::id(),
                'profile_id' => $id,
                'data' => $validatedData,
            ]);

            $familyDetail = FamilyDetail::updateOrCreate(
                ['profile_id' => $id],
                $validatedData
            );

            return ApiResponse::success('Family detail updated successfully', $familyDetail);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Failed to update family detail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to update', $e->getMessage(), 500);
        }
    }

    // Delete a family detail
    public function destroy($id)
    {
        try {
            $familyDetail = FamilyDetail::findOrFail($id);
            $this->authorize('delete', $familyDetail);

            $this->service->delete($id);

            return ApiResponse::success('Family detail deleted successfully');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Family detail not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to delete family detail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to delete', $e->getMessage(), 500);
        }
    }
}