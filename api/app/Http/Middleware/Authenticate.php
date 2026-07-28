<?php


namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle unauthenticated API requests by returning JSON.
     */
    protected function redirectTo(Request $request): ?string
    {
        abort(response()->json([
            'message' => 'Unauthenticated.',
        ], Response::HTTP_UNAUTHORIZED));
    }
}