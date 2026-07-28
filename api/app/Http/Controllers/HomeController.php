<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function homePageData(Request $request)
    {
        // Fetch latest active members
        // Eager load profile, user, and membership relationships
        $members = Member::with(['profile', 'user', 'membership'])
            ->where('status', 'active') // Assuming 'active' status or use scopeActive if available
            ->latest()
            ->take(10)
            ->get();

        // Transform data to match frontend expectations
        $data = $members->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->user ? $member->user->name : 'Unknown',
                'profile_photo' => $member->profile ? $member->profile->profile_photo : null,
                'profile_marital_status' => $member->profile ? $member->profile->marital_status : null,
                'membership_slug' => $member->membership ? $member->membership->slug : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
