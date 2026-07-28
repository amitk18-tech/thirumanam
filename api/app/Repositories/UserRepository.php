<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    // Find a user by ID
    public function find($id)
    {
        return $this->model->find($id);
    }

    // Get all users
    public function all()
    {
        return $this->model->all();
    }

    // Create a new user
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // Update a user by ID
    public function update($id, array $data)
    {
        $user = $this->model->find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    // Delete a user by ID
    public function delete($id)
    {
        $user = $this->model->find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    // Find user by email
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    // Get all properties of a user
    public function getUserProperties($userId)
    {
        $user = $this->model->find($userId);
        return $user ? $user->properties : null;
    }

    // Other custom methods based on relationships like likes, shortlists, chats
    public function getUserLikes($userId)
    {
        $user = $this->model->find($userId);
        return $user ? $user->likes : null;
    }

    public function getUserShortlists($userId)
    {
        $user = $this->model->find($userId);
        return $user ? $user->shortlists : null;
    }

    public function getUserChats($userId)
    {
        $user = $this->model->find($userId);
        return $user ? $user->chats : null;
    }

    public function findByPhone(string $phone)
{
    return \App\Models\User::where('phone', $phone)
        ->orWhere('phone', '+91' . ltrim($phone, '0'))
        ->first();
}
}