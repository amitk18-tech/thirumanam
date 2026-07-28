<?php

namespace Bits\Package\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

abstract class BaseAuthService
{
    protected string $loginField = 'phone'; // default, override in child

    abstract protected function getUserModel(): string;

    /**
     * Detect the login field based on the input value.
     */
    protected function detectLoginField(string $value): string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } elseif (preg_match('/^\d+$/', $value)) {
            return 'phone';
        }
        return 'username';
    }

    /**
     * Hook to load relationships on the user model.
     */
    protected function loadRelationships($user): void
    {
        // Default: no relationships
    }

    /**
     * Hook to format user data before returning.
     */
    protected function formatUserData($user, array $data): array
    {
        return $data;
    }

    public function login(Request $request)
    {
        $userModel = $this->getUserModel();
        $loginValue = $request->get('login_id') ?? $request->get('login_value') ?? $request->get($this->loginField);

        if (!$loginValue) {
            return [
                'success' => false,
                'status' => 422,
                'message' => 'Login identifier is required.',
            ];
        }

        $loginField = $this->detectLoginField($loginValue);
        $user = $userModel::where($loginField, $loginValue)->first();

        if ($user) {
            $this->loadRelationships($user);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'success' => false,
                'status' => 422,
                'message' => 'The provided credentials are incorrect.',
            ];
        }

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $cleanedUser = $user->makeHidden(['password', 'remember_token'])->toArray();

        $role = $user->role;
        $cleanedUser['role_name'] = $role->name ?? null;
        $cleanedUser['role_slug'] = $role->slug ?? null;
        $cleanedUser['permissions'] = method_exists($user, 'getPermissions') ? $user->getPermissions() : [];

        // Apply app-specific formatting
        $cleanedUser = $this->formatUserData($user, $cleanedUser);

        return [
            'success' => true,
            'token' => $token,
            'user' => $cleanedUser,
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return [
                'success' => false,
                'status' => 401,
                'message' => 'User not authenticated.',
            ];
        }

        $user->tokens()->delete();

        return [
            'success' => true,
            'message' => 'Logged out successfully.',
        ];
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return [
                'success' => false,
                'status' => 401,
                'message' => 'User not authenticated.',
            ];
        }

        $user->tokens()->delete();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return [
            'success' => true,
            'token' => $token,
        ];
    }

    public function getLoggedUserDetails(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return [
                'success' => false,
                'status' => 401,
                'message' => 'User not authenticated.',
            ];
        }

        $this->loadRelationships($user);

        $cleanedUser = $user->makeHidden(['password', 'remember_token'])->toArray();

        $role = $user->role;
        $cleanedUser['role_name'] = $role->name ?? null;
        $cleanedUser['role_slug'] = $role->slug ?? null;
        $cleanedUser['permissions'] = method_exists($user, 'getPermissions') ? $user->getPermissions() : [];

        // Apply app-specific formatting
        $cleanedUser = $this->formatUserData($user, $cleanedUser);

        return $cleanedUser;
    }
}
