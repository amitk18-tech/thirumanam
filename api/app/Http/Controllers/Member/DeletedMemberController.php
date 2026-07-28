<?php

namespace App\Http\Controllers\Member;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Member;
use App\Models\DeletedMember;

class DeletedMemberController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = DeletedMember::class;

        $this->middleware(function ($request, $next) {

            $authUser = Auth::user();

            Log::info('MEMBER_DELETE_ACTION', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
            ]);

            $this->service = new BaseService(
                new BaseRepository(new DeletedMember(), null)
            );

            return $next($request);
        });

        $this->storeRules = [
            'member_id' => 'required|exists:members,id',
        ];
    }
    public function destroy($id)
    {
        // $this->authorize('delete', DeletedMember::class);

        DB::transaction(function () use ($id) {
            
            // Treat $id as member_id
            $member = Member::withTrashed()->findOrFail($id);

            // Find associated audit log
            $deletedMember = DeletedMember::where('member_id', $id)->first();

            $member->forceDelete();

            if ($deletedMember) {
                $deletedMember->delete();
            }
        });

        return ApiResponse::success('Member permanently deleted');
    }
    
    public function restore($id)
    {
        // $this->authorize('restore', DeletedMember::class);

        DB::transaction(function () use ($id) {

            // Treat $id as member_id
            $member = Member::withTrashed()->findOrFail($id);

            $member->restore();

            // Cleanup audit log after restore
            DeletedMember::where('member_id', $id)->delete();
        });

        return ApiResponse::success('Member restored successfully');
    }
}
