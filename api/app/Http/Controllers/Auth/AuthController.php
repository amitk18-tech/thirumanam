<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use Bits\Package\Responses\ApiResponse;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authUsernameService)
    {

        $this->authService = $authUsernameService;
    }


    public function login(Request $request)
    {

        try {
            $response = $this->authService->login($request);
            if (!$response['success']) {
                $statusCode = ($response['error_code'] ?? null) === 'ACCOUNT_DEACTIVATED' ? 403 : 401;
                return ApiResponse::error(
                    $response['message'] ?? 'Invalid credentials',
                    [
                        'code' => $response['error_code'] ?? null,
                    ],
                    $statusCode
                );
            }
            return ApiResponse::success('Login successful', $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching with category', $e->getMessage());
        }
    }

    public function adminLogin(Request $request)
    {

        try {
            $response = $this->authService->adminLogin($request);
            if (!$response['success']) {
                return ApiResponse::error($response['message'] ?? 'Invalid credentials');
            }
            
            $message = $response['message'] ?? 'Login successful';
            unset($response['success'], $response['message']); 

            return ApiResponse::success($message, $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching with category', $e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        try {
            $response = $this->authService->logout($request);
            if (!$response['success']) {
                return ApiResponse::error('Logout failed', $response['message']);
            }
            return ApiResponse::success('Logout successful', $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error during logout', $e->getMessage());
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $response = $this->authService->refreshToken($request);
            if (!$response['success']) {
                return ApiResponse::error('Token refresh failed', $response['message']);
            }
            return ApiResponse::success('Token refreshed successfully', $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error refreshing token', $e->getMessage());
        }
    }

    public function getUserDetails(Request $request)
    {
        try {
            $response = $this->authService->getLoggedUserDetails($request);
            if (!$response) {
                return ApiResponse::error('Failed to fetch user details', 'User not found');
            }
            return ApiResponse::success('User details fetched successfully', $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching user details', $e->getMessage());
        }
    }
}

// class AuthController extends Controller
// {

//     protected $authService;

//     public function __construct(AuthService $authUsernameService)
//     {

//         $this->authService = $authUsernameService;
//     }


//     public function login(Request $request)
//     {

//         try {
//             $response = $this->authService->login($request);
//             if (!$response['success']) {
//                 return ApiResponse::error($response['message'] ?? 'Invalid credentials');
//             }
            
//             $message = $response['message'] ?? 'Login successful';
//             unset($response['success'], $response['message']); 

//             return ApiResponse::success($message, $response);
//         } catch (\Throwable $e) {
//             return ApiResponse::error('Error fetching with category', $e->getMessage());
//         }
//     }


//     public function logout(Request $request)
//     {
//         try {
//             $response = $this->authService->logout($request);
//             if (!$response['success']) {
//                 return ApiResponse::error('Logout failed', $response['message']);
//             }
//             return ApiResponse::success('Logout successful', $response);
//         } catch (\Throwable $e) {
//             return ApiResponse::error('Error during logout', $e->getMessage());
//         }
//     }

//     public function refreshToken(Request $request)
//     {
//         try {
//             $response = $this->authService->refreshToken($request);
//             if (!$response['success']) {
//                 return ApiResponse::error('Token refresh failed', $response['message']);
//             }
//             return ApiResponse::success('Token refreshed successfully', $response);
//         } catch (\Throwable $e) {
//             return ApiResponse::error('Error refreshing token', $e->getMessage());
//         }
//     }

//     public function getUserDetails(Request $request)
//     {
//         try {
//             $response = $this->authService->getLoggedUserDetails($request);
//             if (!$response) {
//                 return ApiResponse::error('Failed to fetch user details', 'User not found');
//             }
//             return ApiResponse::success('User details fetched successfully', $response);
//         } catch (\Throwable $e) {
//             return ApiResponse::error('Error fetching user details', $e->getMessage());
//         }
//     }
// }