<?php

namespace App\Repositories;

use App\Models\Follow;

class FollowRepository
{
    public function follow($followerId, $followingId)
    {
        return Follow::firstOrCreate([
            'follower_id' => $followerId,
            'following_id' => $followingId
        ]);
    }

    public function unfollow($followerId, $followingId)
    {
        return Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->delete();
    }

    public function isFollowing($followerId, $followingId)
    {
        return Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->exists();
    }

    public function followers($userId)
    {
        return Follow::where('following_id', $userId)
            ->with('follower')
            ->get();
    }

    public function following($userId)
    {
        return Follow::where('follower_id', $userId)
            ->with('following')
            ->get();
    }
}