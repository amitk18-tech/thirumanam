<?php

namespace Bits\Package\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    protected Model $model;
    protected BaseService $service;
    protected string $policyModel;
    protected array $storeRules = [];
    protected array $updateRules = [];


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user && isset($user->tenant_id) && isset($this->service)) {
                $this->service->repo()->setTenantId($user->tenant_id);
            }
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        try {
            Log::info('ACTION: Fetching data', [
                'user_id' => Auth::id(),
                'tenant_id' => $this->policyModel,
                'filters' => $request->get('filters', []),
                'joins' => $request->get('joins', []),
                'with' => $request->get('with', [])
            ]);
            $this->authorize('viewAny', $this->policyModel);
            $data = $this->service->list(
                $request->get('filters', []),
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


    public function show($id, Request $request)
    {
        try {
            Log::info('ACTION: Viewing record', [
                'user_id' => Auth::id(),
                'tenant_id' => $this->policyModel,
                'record_id' => $id
            ]);
            $data = $this->service->get($id, $request->get('with', []));
            $this->authorize('view', $data);

            return ApiResponse::success('Record found', $data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Record not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve record', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $this->authorize('create', $this->policyModel);
            $validated = $this->validateRequest($request, $this->storeRules);
            Log::info('ACTION: Creating record', [
                'user_id' => Auth::id(),
                'validated_data' => $validated
            ]);

            $model = $this->service->create($validated);
            return ApiResponse::success('Created successfully', $model);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            return ApiResponse::error('Server error', $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $model = $this->service->get($id);
            $this->authorize('update', $model);
            Log::info('ACTION: Updating record', [
                'user_id' => Auth::id(),
                'record_id' => $id,
                'request_data' => $request->all()
            ]);
            $validated = $this->validateRequest($request, $this->updateRules);
            $updated = $this->service->update($id, $validated);
            return ApiResponse::success('Updated successfully', $updated);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            return ApiResponse::error('Server error', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $model = $this->service->get($id);
            $this->authorize('delete', $model);
            Log::info('ACTION: Deleting record', [
                'user_id' => Auth::id(),
                'record_id' => $id
            ]);
            $deleted = $this->service->delete($id);
            return ApiResponse::success('Deleted successfully', $deleted);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to delete', $e->getMessage(), 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $this->authorize('bulkDelete', $this->policyModel);
            $deleted = $this->service->bulkDelete($request->ids);
            return ApiResponse::success('Bulk deleted successfully', $deleted);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Throwable $e) {
            return ApiResponse::error('Bulk delete failed', $e->getMessage(), 500);
        }
    }

    protected function validateRequest(Request $request, array $rules): array
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}