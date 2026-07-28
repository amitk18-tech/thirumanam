<?php

namespace App\Http\Controllers\Profile;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;

class PhotoController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Photo::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('PHOTO: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            $this->service = new BaseService(
                new BaseRepository(new Photo())
            );

            return $next($request);
        });

        $this->storeRules = [
            'profile_id' => 'required|exists:profiles,id',
            'photo_url' => 'nullable|file|image|max:2048', // ✅ fix: expect file
            'is_primary' => 'boolean',
            'is_private' => 'boolean',
        ];

        $this->updateRules = [
            'photo_url' => 'nullable|file|image|max:2048', // ✅ fix for update too
            'is_primary' => 'boolean',
            'is_private' => 'boolean',
        ];
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'profile_id' => 'required|exists:profiles,id',
                'photo_url' => 'required|array|min:1',
                'photo_url.*' => 'required|file|image|max:2048',
                'photo_url.*.is_primary' => 'sometimes|boolean',
                'photo_url.*.is_private' => 'sometimes|boolean',
            ]);

            $photos = [];
            $imageUrls = [];
            $imagePaths = [];

            foreach ($request->file('photo_url') as $index => $file) {

                // Generate unique name same as product image logic
                $uniqueId = uniqid();
                $timestamp = now()->format('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $imageName = "profile_{$uniqueId}_{$timestamp}.{$extension}";

                // Year/Month folder
                $year = now()->format('Y');
                $month = now()->format('m');

                // Save file
                $path = $file->storeAs("photos/{$year}/{$month}", $imageName, 'public');
                $imagePath = "storage/{$path}";

                // Save DB record
                $photoData = [
                    'profile_id' => $validated['profile_id'],
                    'photo_url' => $path,
                    'is_primary' => $request->input("photo_url.{$index}.is_primary", false),
                    'is_private' => $request->input("photo_url.{$index}.is_private", false),
                ];

                $photoRecord = $this->service->create($photoData);

                $photos[] = $photoRecord;
                $imageUrls[] = url($imagePath);
                $imagePaths[] = $imagePath;
            }

            return ApiResponse::success('Photos uploaded successfully', [
                'photos' => $photos,
                'image_urls' => $imageUrls,
                'image_paths' => $imagePaths,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to store photo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to store photo', $e->getMessage(), 500);
        }
    }



    public function update(Request $request, $profileId)
    {
        try {
            $validated = $request->validate([
                'photo_url' => 'sometimes|array|min:1',
                'photo_url.*' => 'file|image|max:21084',
                'deleted_photo_ids' => 'sometimes|string',
            ]);

            return DB::transaction(function () use ($request, $profileId) {

                /** ---------------------------------------------
                 * 1️⃣ DELETE REMOVED PHOTOS
                 * --------------------------------------------- */
                $deletedIds = json_decode($request->deleted_photo_ids ?? '[]', true);

                if (!empty($deletedIds)) {
                    Photo::where('profile_id', $profileId)
                        ->whereIn('id', $deletedIds)
                        ->get()
                        ->each(function ($photo) {
                            if ($photo->photo_url && Storage::disk('public')->exists($photo->photo_url)) {
                                Storage::disk('public')->delete($photo->photo_url);
                            }
                            $photo->delete();
                        });
                }

                /** ---------------------------------------------
                 * 2️⃣ STORE NEW PHOTOS
                 * --------------------------------------------- */
                $newPhotos = [];

                if ($request->hasFile('photo_url')) {
                    foreach ($request->file('photo_url') as $file) {

                        $uniqueId = uniqid();
                        $timestamp = now()->format('Ymd_His');
                        $extension = $file->getClientOriginalExtension();
                        $imageName = "profile_{$uniqueId}_{$timestamp}.{$extension}";

                        $year = now()->format('Y');
                        $month = now()->format('m');

                        $path = $file->storeAs(
                            "photos/{$year}/{$month}",
                            $imageName,
                            'public'
                        );

                        $photo = Photo::create([
                            'profile_id' => $profileId,
                            'photo_url' => $path,
                            'is_primary' => false,
                            'is_private' => false,
                        ]);

                        $newPhotos[] = $photo;
                    }
                }

                /** ---------------------------------------------
                 * 3️⃣ RETURN UPDATED LIST
                 * --------------------------------------------- */
                $allPhotos = Photo::where('profile_id', $profileId)->get();

                return ApiResponse::success('Photos updated successfully', [
                    'photos' => $allPhotos,
                    'new_photos' => $newPhotos,
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Failed to update photos', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error(
                'Failed to update photos',
                $e->getMessage(),
                500
            );
        }
    }



}