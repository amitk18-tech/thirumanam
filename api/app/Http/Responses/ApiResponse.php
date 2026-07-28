<?php

namespace App\Http\Responses;

class ApiResponse
{
    // Success response
    public static function success($message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => null
        ]);
    }

    // General error response
    public static function error($message, $error = null, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'error' => $error
        ], $statusCode);
    }

    // Authorization error (403)
    public static function authError($action, $error = null)
    {
        $message = 'Forbidden. You don\'t have permission to '. $action . ' data';  // Fixed concatenation
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'error' => $error
        ], 403);
    }

    // Unauthorized error (401)
    public static function unauthorized($message = 'Unauthorized! Please login', $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'error' => $error
        ], 401);
    }

    // Custom error response (with any status code)
    public static function customError($message, $error = null, $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'error' => $error
        ], $statusCode);
    }
}
